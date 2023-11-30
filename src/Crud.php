<?php
namespace MyApp;
use MyApp\Connection;
use MyApp\crud_config;
define('CRUD_PATH', str_replace('\\', '/', dirname(__file__))); // str_replace - windows trick
// require (CRUD_PATH . '/functions.php');
// use MyApp\ErrorResponse;
class Crud extends Connection{
    public int $getid=0;
    public int $offse=0;
    public int $limit=10;
    private bool $add_btn=false;
    private bool $edit=false;
    private bool $delete_list_btn=false;
    private bool $delete_btn=false;
    private bool $edit_btn=false;
    private bool $table_title=false;
    private  $fields=array();
    private  $join=array();
    private  $relation=array();
    private  $column_cut=array();
    public array  $btns=array();
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


    public function fields(){
        $sql="SHOW FIELDS FROM {$this->table}";
        $result=$this->con->prepare($sql);
        $result->execute();
        $e=$result->get_result()->fetch_all(MYSQLI_ASSOC);
        $_SESSION['crud']['id']=$e[0]['Field'];
        return $e;
    }

    public function delete_list_btn(){
        if($this->delete_list_btn !==true){
            echo "<button class='m-2' type='submit' onclick='deleteAll()'>Delete Selected Records</button>";
        }
    }

    public function add_btn(){
        if($this->add_btn !==true){
            echo "<button class='m-2 float-right' type='submit' onclick='load()'>Add</button>";
        }
    }

    public function table_title(){
        if($this->table_title !==true){
            echo "<h3 class='text-center text-muted'>&lt; {$_SESSION['crud']['d']} . {$_SESSION['crud']['t']} &gt;</h3>";
        }
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

        public function create_btn($name='',$link='',$class=false,$attr=array()){
            // if($class != false){
            //     $add_class=$class;
            // }
            // if(count($attr) != 0){
            //     foreach($attr as $key=>$value){
            //         $add_attr.="{$key}='{$value}' ";
            //     }
            // }
            $this->btns[]= ['name'=>$name,'link'=>$link,'class'=>$class,'attr'=>$attr];
        }

        public function join($pri_column,$for_column,$rel_table){}

        public function relation($pri_column,$for_column,$rel_table){}

        public function coloumn_class($pri_column,$for_column,$rel_table){}

        public function coloumn_cut($pri_column,$for_column,$rel_table){}

        public function unset_edit($bool){
            $this->edit_btn=(bool)$bool;
        }

        public function unset_delete($bool){
            $this->delete_btn=(bool)$bool;
        }

        public function unset_delete_list_btnt($bool){
            $this->delete_list_btn=(bool)$bool;
        }

        public function unset_add($bool){
            $this->add_btn=(bool)$bool;
        }

        public function unset_delete_list_btn($bool){
            $this->delete_list_btn=(bool)$bool;
        }

        public function unset_table_title($bool){
            $this->table_title=(bool)$bool;
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
        public function charlenset($char,$start,$total){
            if(strlen($char) >= 20){
                return substr($char,$start,$total)."...";
            }else{
            return $char;
            }
        }



    public function get_instance():void{
        $this->fields=$this->fields();
        $this->table_title();
        $this->delete_list_btn();
        $this->add_btn();
        @include (CRUD_PATH."/"."theme"."/".crud_config::$theme_name."/crud_list_view.php");
    }
    private function close(){
        if($this->checkstatus){
          $this->con->close();
          $this->checkstatus=false;
        }
    }
}


?>