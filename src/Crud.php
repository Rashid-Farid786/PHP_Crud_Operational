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
        public function charlenset($char,$start,$total){
            if(strlen($char) >= 20){
                return substr($char,$start,$total)."...";
            }else{
            return $char;
            }
        }



    public function get_instance():void{
        include (CRUD_PATH."/"."theme"."/".crud_config::$theme_name."/crud_list_view.php");
    }
    private function close(){
        if($this->checkstatus){
          $this->con->close();
          $this->checkstatus=false;
        }
    }
}


?>