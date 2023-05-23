<?php
namespace MyApp;
use MyApp\Connection;
// use MyApp\ErrorResponse;
class Crud extends Connection{
    public $getid=0;
    public function __construct(string $host,string $user,string $password,string $db){
        parent::__construct($host,$user,$password,$db);
        // parent::__construct();
        // new Connection($host,$user,$password,$db);

        // $this->host_name=$host;
        // $this->user_name=$user;
        // $this->password=$password;
        // $this->db_name=$db;
        // if(!$this->checkstatus){
        //     $this->con=mysqli_connect($this->host_name,$this->user_name,$this->password,$this->db_name);
        //     if(!$this->con->connect_error){
        //         $this->checkstatus=true;
        //         // $this->crus=new Crud();
        //     }else{
        //         $this->checkstatus=false;
        //         die($this->con->connect_error);
        //     }
        // }
    }
    public function get($sql){
        $e=$this->con->prepare($sql);
        $e->execute();

        if(!$this->con->error){
            return $e->get_result()->fetch_all();
        }else{
            return false;
        }

        }


        public   function query1($sql){
        $e=$this->con->prepare($sql);
        $e->execute();

        if(!$this->con->error){
            return true;
        }else{
            return false;
        }

        }



    public function instance():void{
        $sql="SHOW FIELDS FROM {$this->table}";
        $result=$this->con->prepare($sql);
        $result->execute();
        $e=$result->get_result()->fetch_all(MYSQLI_ASSOC);
        $_SESSION['crud']['id']=$e[0]['Field'];
        if(!$this->con->error){
        $this->data="
        <button class='m-2' type='submit' onclick='deleteAll()'>Delete Selected Records</button>
        <table class='crudtable table table-sm table-borderless table-responsive-sm crudtable'>
        <thead class='thead-dark w-100'>
        <tr>
        <th class='text-center'><input type='checkbox' id='check' onclick='checkbox()'/></th>";
        foreach($e as $key=>$value){
            $this->data.="
            <th scope='col' class='text-center'>".$value['Field']."</th>";
        }
        $this->data.="
        <th class='text-center'>Update</th>
        <th class='text-center'>Delete</th>
        </tr>
        </thead>";
    }
    $sql="SELECT * FROM {$this->table} LIMIT {$this->offset},{$this->limit}";
   $result1=$this->customquery($sql);
//    echo "<pre>";
//    print_r($result1);die();
   $this->getid=$result1[0]['id']??"";
foreach($result1 as $value){
        if(is_array($value) OR (is_object($value))){
            $this->data.="
            <tr>
            <td class='text-center'>
            <input type='checkbox' value='{$this->getid}' name='checkbox'/>
            </td>";
            // $id=$this->getid+1;
    foreach($value as $key=>$value1){
        if($key == 'id'){
            $this->getid=$value['id'];
        }
    //     echo "<pre>";
    //    echo $value1 ;die();
        if($key == 0 && $value1 !=null){
            $this->data .="
            <td class='text-center'>".str_replace("'",'',$value1)."</td>";
        }
        elseif((is_string($value1))){
            if(strlen($value1)>100){
                $this->data .="
                <td class='text-center'>".str_replace("'",'',substr($value1,0,100))."</td>";
            }
        }
        $str=$value1??"";
        $this->data .="
        <td class='text-center'>".str_replace("'",'',$str)."</td>";
    }
    $this->data.="
    <td class='text-center'>
    <button id='".$this->getid."' onclick='updateOpen(this)'>
    &#8634;
    </button>
    </td>
    <td class='text-center'>
    <button id='".$this->getid."' onclick='deletedata(this)'>
    X
    </button>
    </td>
    </tr>";
    $this->getid++;
    }
    }
   
$this->data.="</table>";
$previus;
$nest;
$pages=0;
// if(!isset($_GET['page'])){
// $pages=$_GET['page']?$_GET['page']:0;
// }
if($this->pagination){
    $sql="SELECT * FROM {$this->table}";
        $e=$this->con->query($sql);
        if($e->num_rows>0){
    if(isset($_GET['page'])){
         $this->offset=($pages-1)*$this->limit;
            $this->total_pages=ceil($e->num_rows/$this->limit);
            // echo "Page set ".$e->num_rows;
            $previus=$pages-1;
            $nest=$pages+1;
                 
    }else{
         $this->offset=(0-1)*$this->limit;
            $this->total_pages=ceil($e->num_rows/$this->limit);
            // echo "Page Not Set ".$e->num_rows;        
    }
        }
                

        $this->data.="
        <table class='table w-10 text-center'>
        <nav class='page navigation example'>
        <ul class='pagination list-group'>
        <tr>";
        if($pages>1){
            $this->data.="<td  class='page-item'>
            <li' class='page-item'>
            <a href='{$_SERVER['PHP_SELF']}?page={$previus}' class='page-link'>Previus</a>
            </td>"; 
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
$this->data.="
<td>
<li style='list-style:none;' class='page-item'>
<a href='{$_SERVER['PHP_SELF']}?page={$i}' class='page-link {$active}'>{$i}</a>
</li>
</td>";
}
if($pages < $this->total_pages){
    $this->data.="<td>
    <li style='list-style:none;' class='page-item'>
    <a href='{$_SERVER['PHP_SELF']}?page= class='page-link'>Next</a>
    </li>
    </td>
    </ul>
    </nav>";
}
$this->data.="</tr></table>";
}   
    echo $this->data;

    }
    private function close(){
        if($this->checkstatus){
          $this->con->close();
          $this->checkstatus=false;
        }
    }
}


?>