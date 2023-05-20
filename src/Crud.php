<?php
namespace MyApp;
use MyApp\Connection;
class Crud extends Connection{
    public Connection $conn;
    public function __construct($host=null,$user=null,$password=null,$db=null){
        parent::__construct($host,$user,$password,$db);
        // new Connection($host,$user,$password,$db);
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
        if(!$this->con->error){
        $this->data="
        <table class='crudtable table table-sm table-hover table-responsive-sm'>
        <form action='{$_SERVER['PHP_SELF']}' method='get'>
        <button class='m-2' type='submit'>Delete Selected Records</button>
        <thead class='thead-dark w-100'>
        <tr>
        <th class='text-center'>Delete</th>";
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
   foreach($result1 as $value){
    if(is_array($value)){
    foreach($value as $value1){
        if(is_array($value1) OR (is_object($value1))){
            $this->data.="<form action='{$_SERVER['PHP_SELF']}' method='get'>
            <tr>
            <td class='text-center'>
            <input type='checkbox' name='checkbox'/>
            </td>";
    foreach($value1 as $value2){
        if($key == 0 && $value !=null){
            $this->data .="
            <td class='text-center'>".str_replace("'",'',$value2)."</td>";
        }
        elseif((is_string($value2))){
            if(strlen($value2)>100){
                $this->data .="
                <td class='text-center'>".str_replace("'",'',substr($value2,0,100))."</td>";
            }
        }
        $str=$value2??"";
        $this->data .="
        <td class='text-center'>".str_replace("'",'',$str)."</td>";
    }

    $this->data.="
    <td class='text-center'>
    <form action='{$_SERVER['PHP_SELF']}' method='get'>
    <button>
    <input type='submit' hidden name='update' value='".$this->id."'>
    &#8634;
    </button>
    </form>
    </td>
    <td class='text-center'>
    <form action='{$_SERVER['PHP_SELF']}''method='get'>
    <button>
    <input type='submit' hidden name='delete' value='".$this->id."'>
    X
    </button>
    </form>
    </td>
    </tr>";
    }
    }
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