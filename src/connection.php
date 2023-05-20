<?php
namespace MyApp{
    // use MyApp\ErrorResponse;

class Connection{
    public $user_name;
    public $host_name;
    public $password;
    public $db_name;
    public $con;
    public $table;
    public $id;
    public $data;
    public $checkstatus;
    public $offset=0;
    public $limit=100;
    public $crud;
    public $pagination=false;
    public $total_pages;
    // create Connection
    public function __construct($host,$user,$password,$db){
        if(!$this->checkstatus){
            $this->host_name=$host;
            $this->user_name=$user;
            $this->password=$password;
            $this->db_name=$db;
            $this->con=mysqli_connect($this->host_name,$this->user_name,$this->password,$this->db_name);
            if(!$this->con->connect_error){
                $this->checkstatus=true;
                $this->crus=new Crud();
            }else{
                $this->checkstatus=false;
                die($this->con->connect_error);
            }
        }
    }

    // select database table
    public function settable($table){
        if($this->checkstatus){
        $this->table=$table;
        }else{
            echo "Connect error";
        }
    }
    public function changetable($table){
        if($this->checkstatus){
        $this->table=$table;
        }else{
            echo "Connect error";
        }
    }

    // Query To Database
    public function Query(string $sql):array{
        if($this->checkstatus){
            $request=$this->con->prepare($sql);
            $request->execute();
            if($request){
                if($request->affected_rows<>0){
                    return $this->convert(true,"Success",'',(array)$request->get_result()->fetch_all(MYSQLI_ASSOC));
                    }else{
                    return $this->convert(false,"Data Not Found",$this->con->error,"");
                }
            }else{
                return $this->convert(true,"Query Error",$this->con->error,"");
            }
        }
    }
    public function adddata(){

    }

    // Check Connection Status
    public function status(){
        return $this->con->connection_stats;
    }

    // get Table Data By ID
    public function find(int $id):array{
        $sql="SELECT * FROM {$this->table} WHERE id=?";
        $e=$this->con->prepare($sql);
        $e->bind_param("i",$id);
        $e->execute();
        if(!$this->con->error){
            return $this->convert(true,"success","",$e->get_result()->fetch_all());
        }else{
            return $this->convert(false,"Data Not Found",$this->con->error,"");
        }
    }
    public function customquery(string $data){
        $e=$this->con->prepare($data);
        $e->execute();
        if(!$this->con->error){
        $result=$e->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    }

    // Selct All Database Data
    public function all():array{
        $sql="SELECT * FROM ".$this->table;
        $e=$this->con->prepare($sql);
        $e->execute();
        $request=$e->get_result()->fetch_all();
        if($this->con->error>0){
            return $this->convert(false,"Get All Data Query Error","","");
        }else{
            return $this->convert(true,"success",$this->con->error,$request);
        }
    }

    // insert Data In Database
    public function insert(array $arr):array{
        extract($arr);
        $keys=implode(",",array_keys($arr));
        $values="";
        foreach($arr as $key=>$value){
            // store array values in values variable
            $values.="'".$value."',";
        }
        $sql="INSERT INTO {$this->table} ({$keys}) VALUES(".trim($values,',').")";
        $e=$this->con->prepare($sql);
        $e->execute();
        if(!$this->con->error){
            return $this->convert(true,"success","",["id"=>$this->con->insert_id]);
        }else{
            return $this->convert(false,"Data Not Inserted",$this->con->error,'');
        }
    }

    // insert Data With Image
    public function mixer(array $arr,array $file,string $filepath):array{

        // upload image code
        $error = array();
		$name = $_FILES['file']['name'];
		$size = $_FILES['file']['size'];
		$tempname = $_FILES['file']['tmp_name'];
		$type = $_FILES['file']['type'];
		$refrence = explode('.', $name);
		$file_exe = end($refrence);
		$extention = array('jpeg', 'jpg', 'png', 'pdf', 'docx');
		$new_name = time() . basename($name);
		$fileupload = "../upload/" . $new_name;
		if (in_array($file_exe, $extention) === false) {
			$error[] = "please select valid iamge jpg or png";
		}
		if ($size > 3145728) {
			$error[] = "uploaded image 3MB or lower";
		}
		if (empty($error == true)) {
			move_uploaded_file($tempname, $fileupload);
		} else {
			echo "<script>message('".$error[0]."')</script>";
			die();
		}
        // end uploadI Image

        // Inser Data Code
        $k=array_keys($arr);
        $keys=implode(",",$k);
        $values="";
        $questionMark="";
        $datatype="";
        foreach($arr as $key=>$value){
                
            // store array values in values variable
                $values.="'{$value}' ,";
                
                // store question marks in variable
                $questionMark.="? ,";

                // Pickup data datatype
                switch(gettype($value)){
                    case "string":
                    $datatype .='s';
                    break;
                    case 'integer':
                    $datatype.='i';
                    case 'boolean':
                    $datatype.='b';
                    break;
                    default:
                }
        }

        $passquestionmark=trim($questionMark,',');
        $passvalues=trim($values,',');
        $passarray=explode(',',$passvalues);
        list($name,$email,$password)=$passarray;
        $passdatatype=trim($datatype);
        $sql="INSERT INTO {$this->table}({$keys}) VALUES({$passquestionmark})";
        $e=$this->con->prepare($sql);
        // echo $passdatatype.",".$passvalues;die();
        $e->bind_param($passquestionmark,$name,$email,$password);
        $e->execute();
        if(!$this->con->error){
            return $this->convert(true,"success","",(array)$this->con->insert_id);
        }else{
            return $this->convert(false,"Data Not Inserted",$this->con->error,'');
        }
    }
     public function colums():array{
        $sql="SHOW ALL COLUMS FROM {$this->table}";
        $result=$this->con->prepare($sql);
        $result->execute();
        if(!$this->con->error){
            return $this->convert(true,"success","",$result->get_result()->fetch_all());
        }else{
            return $this->convert(false,"error",$this->con->error,"");
        }
     }

    // Update Already Exist Data Fron DataBase Table
    public function update(array $arr,int $id):array{
        // $datatype="";
        // $keys="";
        $values="";
        foreach($arr as $key=>$value){
            $values.=$key." = ".$value.", ";
            // $keys.="{$key} = ? ,";
            // $values.=$value.", ";
            // switch(gettype($value)){
            //     case "string":
            //     $datatype .='s';
            //     break;
            //     case 'integer':
            //     $datatype.='i';
            //     case 'boolean':
            //     $datatype.='b';
            //     break;
            //     default:
            // }
        }
        // $pe=trim($datatype,",");
        // $ve=trim($values,",");
        // $vve=trim($ve,"'");
        // $passarray=explode(',',$vve);
        // $listvalue="";
        // foreach($passarray  as $key=>$v){
        //     $listvalue.="$"."e".$key.", ";
        // }
        // $listpassvalue=trim(",",$listvalue);
        // list($listpassvalue)=$passarray;
        // ($datatype.",".$values);
        $passvalue=trim($values,",");
        echo $sql="UPDATE {$this->table} SET {$passvalue} WHERE id={$id}";die();
        $e=$this->con->prepare($sql);
        // $e->bind_param($pe,$listpassvalue);
        $e->execute();
        if(!$this->con->error){
            return $this->convert(true,"Data Updated","",(array)["id"=>$id]);
        }else{
            return $this->convert(false,"Data Not Updated",$this->con->error,(array)$this->con->error);
            die();
    }
    }

    // Delete Already Exist Data Fron DataBase Table
    public function delete(int $id):array{
        $sql="DELETE FROM {$this->table} WHERE id={$id}";
        $e=$this->con->prepare($sql);
        $e->execute();
        if($e->num_rows>0){
            return $this->convert(true,"success","",["id"=>$id]);
        }else{
            return $this->convert(false,"Deleted Data Not Found",$this->con->error,"");
        }
    }

    // Check Selected Data Base Table
    public function gettable():string{
        return $this->table;
    }
    private function foreach($data){
        $edata=[];
        foreach($data as $key=>$value){
        }
    }
    public function pagination(int $offset,int $limit){
        $this->pagination=true;
        $this->offset=$offset;
        $this->limit=$limit;
    }
    
    
   
    // add Data Width Image
    public function add(){}

    // Cover Array To Object for Response
    private function convert(bool $staus,String $message,string $error,$data):array{
        $object;
        if(is_array($data)){
            $object=$data;
            }else if(is_object($data)){
                $object=$data;
            }else if(is_bool($data)){
                $object=$data;
            }else{
                $object=["data"=>"none"];
            }
            return(array)(new ErrorResponse($staus,$message,$error,$object));
    }

        // Close Database Connection
   
}

}
?>
