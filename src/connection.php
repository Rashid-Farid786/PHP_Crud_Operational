<?php
namespace MyApp{
    set_error_handler(function($errorno,$errorstr,$errorfile,$errorline){
        echo "<script>message('Error : {$errorstr} , the line number is : {$errorline} and the file is : ".basename($errorfile)."','crudwhite');</script>";
    });
    set_exception_handler(function(Throwable $exception){
        echo '<script>message("Error : '.$exception->getmessage().' on line number is : '.$exception->getLine().' and file is : '.basename($exception->getfile()).'","crudwhite");</script>';
     });
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/css/style.css">
    <script>
        function message(message,status){
        let tag=document.createElement("h3");
        let text=document.createTextNode(message);
        tag.classList.add(status);
        tag.appendChild(text);
        document.write(tag.outerHTML);
        setTimeout(function(){
            tag.remove();
        },1000);
    }
    </script>
    <?php
class Obj{
    public $status;
    public $message;
    public $error;
    public $data;
    public function __construct(bool $status,string $message,string $error,array $data){
        $this->status=$status;
        $this->message=$message;
        $this->error=$error;
        $this->data=$data;
    }
}

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
        // $Keys1="";
        $values="";
        // $questionMark="";
        // $datatype="";
        foreach($arr as $key=>$value){
            // store array values in values variable
            $values.="'".$value."',";
            // $values.=$$key.",";
            // store question marks in variable
            // $questionMark.="? ,";
            // Pickup data datatype
            // switch(gettype($value)){
            //     case "string":
            //         $datatype .='s';
            //         break;
            //         case 'integer':
            //             $datatype.='i';
            //             case 'boolean':
            //         $datatype.='b';
            //         break;
            //         default:
            //     }
        }
        // $passquestionmark=trim($questionMark,',');
        // $passvalues=trim($values,',');
        // $passvaluess=trim($passvalues,"'");
        // echo $passvalues;die();
        // $passarray=explode(',',$passvalues);
        // list($name,$email,$password)=$passarray;
        // $passdatatype=trim($datatype);
        $sql="INSERT INTO {$this->table} ({$keys}) VALUES(".trim($values,',').")";
        $e=$this->con->prepare($sql);
        // echo $passdatatype.",".$passvalues;die();
        // $e->bind_param($passdatatype,$passvaluess);
        $e->execute();
        if(!$this->con->error){
            return $this->convert(true,"success","",["id"=>$this->con->insert_id]);
        }else{
            return $this->convert(false,"Data Not Inserted",$this->con->error,'');
        }
    }
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
        $datatype="";
        $keys="";
        $values="";
        foreach($arr as $key=>$value){
            $keys.="{$key} = ? ,";
            $values.=$value.", ";
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
        $pe=trim($datatype,",");
        $ve=trim($values,",");
        $vve=trim($ve,"'");
        $passarray=explode(',',$vve);
        $listvalue="";
        foreach($passarray  as $key=>$v){
            $listvalue.="$"."e".$key.", ";
        }
        $listpassvalue=trim(",",$listvalue);
        list($listpassvalue)=$passarray;
        ($datatype.",".$values);
        $sql="UPDATE {$this->table} SET ".trim($keys,',')." WHERE id={$id}";
        $e=$this->con->prepare($sql);
        $e->bind_param($pe,$listpassvalue);
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
    
    public function instance():void{
        $sql="SHOW FIELDS FROM {$this->table}";
        $result=$this->con->prepare($sql);
        $result->execute();
        $e=$result->get_result()->fetch_all(MYSQLI_ASSOC);
        if(!$this->con->error){
        $this->data="<table class='crudtable table table-sm table-hover table-responsive-sm'><form action='{$_SERVER['PHP_SELF']}' method='get'>
        ";?>
        <caption>All Records</caption>
        <?php
        $this->data.="
        <button class='m-2' type='submit'>Delete Selected Records</button>
        <thead class='thead-dark w-100'><tr><th class='text-center'>Delete</th>";
        foreach($e as $key=>$value){
            $this->data.="<th scope='col' class='text-center'>".$value['Field']."</th>";
        }
        $this->data.="<th class='text-center'>Update</th><th class='text-center'>Delete</th></tr></thead>";
    }
    echo $sql="SELECT * FROM {$this->table} LIMIT {$this->offset},{$this->limit}";
    echo "<br>";
   $result1=$this->query($sql);
   foreach($result1 as $value){
    if(is_array($value)){
    foreach($value as $value1){
        if(is_array($value1) OR (is_object($value1))){
            $this->data.="<form action='{$_SERVER['PHP_SELF']}' method='get'><tr><td class='text-center'><input type='checkbox' name='checkbox'/></td>";
    foreach($value1 as $value2){
        if($key == 0 && $value !=null){
            $this->data .="<td class='text-center'>".str_replace("'",'',$value2)."</td>";
        }
        elseif((is_string($value2))){
            if(strlen($value2)>100){
                $this->data .="<td class='text-center'>".str_replace("'",'',substr($value2,0,100))."</td>";
            }
        }
        $str=$value2??"";
        $this->data .="<td class='text-center'>".str_replace("'",'',$str)."</td>";
    }

    $this->data.="<td class='text-center'><form action='{$_SERVER['PHP_SELF']}' method='get'><button><input type='submit' hidden name='update' value='".$this->id."'>&#8634;</button></form></td><td class='text-center'><form action='{$_SERVER['PHP_SELF']}' method='get'><button><input type='hidden'  name='delete' value='".$this->id."'>X</button></form></td></tr>";
    }
    }
}
   }
   
   $this->data.="</table>";
$previus;
$nest;
$pages=0;
if(!isset($_GET['page'])){
$pages=$_GET['page']?$_GET['page']:0;
}
if($this->pagination){
    $sql="SELECT * FROM {$this->table}";
        $e=$this->con->query($sql);
        if($e->num_rows>0){
    if(isset($_GET['page'])){
         $this->offset=($pages-1)*$this->limit;
            $this->total_pages=ceil($e->num_rows/$this->limit);
            echo "Page set ".$e->num_rows;
            $previus=$pages-1;
            $nest=$pages+1;
                 
    }else{
         $this->offset=(0-1)*$this->limit;
            $this->total_pages=ceil($e->num_rows/$this->limit);
            echo "Page Not Set ".$e->num_rows;        
    }
        }
                

        $this->data.="<table class='table w-10 text-center'><nav class='page navigation example'><ul class='pagination list-group'><tr>";
        if($pages>1){
            $this->data.="<td  class='page-item'><li' class='page-item'><a href='{$_SERVER['PHP_SELF']}?page={$previus}' class='page-link'>Previus</a></td>"; 
        }
for($i=1;$i<=$this->total_pages;$i++){
    if($this->total_pages >=8){

    }else{

    }
    $active="";
    if(isset($_GET['page'])){
    if($_GET['page']== $i){
        $active="active";
    }else{
        $active="";
    }
}
$this->data.="<td><li style='list-style:none;' class='page-item'><a href='{$_SERVER['PHP_SELF']}?page={$i}' class='page-link {$active}'>{$i}</a></li></td>";
}
if($pages < $this->total_pages){
    $this->data.="<td><li style='list-style:none;' class='page-item'><a href='{$_SERVER['PHP_SELF']}?page={$nest}' class='page-link'>Next</a></li></td></ul></nav>";
}
$this->data.="</tr></table>";
}   
    echo $this->data;

    }
   

    public function add(){

    }

    // Cover Array To Object
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
            return(array)(new obj($staus,$message,$error,$object));
    }

        // Close Database Connection
    private function __destrunct(){
        if($this->checkstatus){
          $this->con->close();
          $this->checkstatus=false;
        }
    }
}

}
?>
