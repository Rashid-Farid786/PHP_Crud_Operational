<?php
namespace MyApp;
?>
<!-- Pup up css code -->
<style>
    .cruderror,.crudsuccess,.crudwhite{
        max-width:80%;
        padding:5px 20px;
        border-radius:10px;
        position:fixed;
        top:2%;
        left:20%;
        transform:translateX(-50%);
        z-index:10000;
        display:flex;
        font-size:40px;
        align-items:center;
        align-content:center;
        justify-content:center;
        transform:translate(-10%,-10%);
    }
    .cruderror{
        color:rgba(255,0,0,1);
        background:rgba(150,0,0,0.3);
    }
    .crudsuccess{
        color:rgba(0,255,0,1);
        background:rgba(0,150,0,0.5);
    }
    .crudwhite{
        color:white;
        background: #222222;
    }
</style>
<!-- pup up code -->
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
 error_reporting(0);
 ini_set("display_errors",0);
function errorHandler($errorno,$errorstr,$errorfile,$errorline){
    echo "<script>message('Error : {$errorstr} , the line number is : {$errorline} and the file is : ".basename($errorfile)."','crudwhite');</script>";
}
function exeptionHandler(Throwable $exception){
   echo '<script>message("Error : '.$exception->getmessage().' on line number is : '.$exception->getLine().' and file is : '.basename($exception->getfile()).'","crudwhite");</script>';
}
set_error_handler("errorHandler");
set_exception_handler("exeptionHandler");
// class obj{
//     public $status;
//     public $message;
//     public $error;
//     public $data;
//     public function __construct(bool $status,string $message,string $error,array $data){
//         $this->status=$status;
//         $this->message=$message;
//         $this->error=$error;
//         $this->data=$data;
//     }
// }
class Connection{
    private $user_name;
    private $host_name;
    private $password;
    private $db_name;
    private $con;
    private $table;
    private $checkstatus;
    // create Connection
    public function __construct($host,$user,$password,$db){
        if(!$this->checkstatus){
            $this->host_name=$host;
            $this->user_name=$user;
            $this->password=$password;
            $this->db_name=$db;
            $this->con= new mysqli($this->host_name,$this->user_name,$this->password,$this->db_name);
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

    // Check Connection Status
    public function status(){
        return $this->con->connection_stats;
    }

    // get Table Data By ID
    public function find($id):array{
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
        $k=array_keys($arr);
        $keys=implode(",",$k);
        $values="";
        $questionMark="";
        $datatype="";
        foreach($arr as $key=>$value){
                $values.="'{$value}' ,";
                $questionMark.="? ,";
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
        $e->bind_param("sss",$name,$email,$password);
        $e->execute();
        if(!$this->con->error){
            return $this->convert(true,"success","",(array)$this->con->insert_id);
        }else{
            return $this->convert(false,"Data Not Inserted",$this->con->error,'');
        }
    }

    // Update Already Exist Data Fron DataBase Table
    public function update($arr,$id){
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
        list($name,$email,$password)=$passarray;
        ($datatype.",".$values);
        $sql="UPDATE {$this->table} SET ".trim($keys,',')." WHERE id={$id}";
        $e=$this->con->prepare($sql);
        $e->bind_param($pe,$name,$email,$password);
        $e->execute();
        if(!$this->con->error){
            return $this->convert(true,"Data Updated","",(array)["id"=>$id]);
        }else{
            return $this->convert(false,"Data Not Updated",$this->con->error,(array)$this->con->error);
            die();
    }
    }

    // Delete Already Exist Data Fron DataBase Table
    public function delete($id){
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
    public function gettable(){
        return $this->table;
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
function breake_arry($arr){
    $re;
    foreach($arr as $key=>$value){
        if(is_array($value)){
                // array_push($re,$value1);
                $re[$key]=$value;
        }
            // array_push($re,$value);
            $re[$key]=$value;
        }
        return $re;
}
?>
