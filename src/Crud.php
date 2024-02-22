<?php
namespace MyApp;
use MyApp\Connection;
use MyApp\crud_config;
define('CRUD_PATH', str_replace('\\', '/', dirname(__file__))); // str_replace - windows trick
// require (CRUD_PATH . '/functions.php');
// use MyApp\ErrorResponse;
class Crud extends Connection{
    private int $getid=0;
    private bool $add_btn=false;
    private bool $edit=false;
    private bool $delete_list_btn=false;
    private bool $delete_btn=false;
    private bool $edit_btn=false;
    private bool $table_title=false;
    private int $offset;
    private int $limit;
    private bool $pagination=false;
    private int $total_pages;
    private  $fields=array();
    private  $types=array();
    private  $null=array();
    private  $join=array();
    private  $relation=array();
    private  $column_cut=array();
    public array  $btns=array();

    
    public function __construct(){
        parent::__construct();
        $this->offset=Crud_config::$offset;
        $this->limit=Crud_config::$limit;
    }

    private function _pase($value){

    }

    private function open_tag($name,$content,$class=false,$attr=[]){

        $tag="<{$name}";
        if($class != false){
            $tag.=" {$class} ";
        }
        if(count($attr)>0){
            foreach($attrc as $key=>$value){
                $tag.=" {$key}=='{$value}' ";
            }
        }
        $tag.=">{$content}</{$name}>";
        return $tag;
    }

    private function close_tag($name){
        return "</{$name}>";
    }

    // private function create_btn($name,$link=false,$type=false,$class=false,$attr=[]){
        
    // }


    public function fields(){
        $sql="SHOW FIELDS FROM {$this->table}";
        $result=$this->con->prepare($sql);
        $result->execute();
        $e=$result->get_result()->fetch_all(MYSQLI_ASSOC);
        $_SESSION['crud']['id']=$e[0]['Field'];
        return $e;
    }

        // select database table
        public function settable($table){
            $this->table=$table;
            session_start();
            $_SESSION['crud']=["u"=>Crud_config::$db_user,"h"=>Crud_config::$db_host,"d"=>Crud_config::$db_name,"t"=>$this->table,"p"=>Crud_config::$db_password];
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


        public function create_btn($name='',$link='',$class=false,$attr=array()){
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
        @include (CRUD_PATH."/".crud_config::$theme_path."/".crud_config::$theme_name."/crud_list_view.php");
    }
    private function close(){
        if($this->checkstatus){
          $this->con->close();
          $this->checkstatus=false;
        }
    }

    public function gettable():string{
        return $this->table;
    }
    private function foreach($data){
        $edata=[];
        foreach($data as $key=>$value){
        }
    }

    public function pagination(int $offset,int $limit=null){
        $this->offset=$offset;
        if($limit != null){
            $this->limit=$limit;
        }
        $this->pagination=true;
    }

    private function convert(bool $staus,String $message,string $error,$data):array{
        $object=object;
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

    public function Upload_imgaes($files,$path='../../upload',$img_size=3145728,$img_ext=array('jpeg', 'JPEG', 'JPG', 'jpg', 'png', 'PNG', 'pdf', 'docx')){
        $error = array();
        $multi_files='';
        if(is_array($files)){
            foreach($files as $key=>$values ){

                $name = $values['name'];
		$size = $values['size'];
		$tempname = $values['tmp_name'];
		$type = $values['type'];
		$refrence = explode('.', $name);
		$file_exe = end($refrence);
		$extention =$img_ext;
		$new_name = time() . basename($name);
		$fileupload = "/" . $new_name;
		if (in_array($file_exe, $extention) === false) {
			$error[] = "please select valid iamge jpg or png";
		}
		if ($size > $img_size) {
			$error[] = "uploaded image 2MB or lower";
		}
		if (empty($error == true)) {
			move_uploaded_file($tempname, $fileupload);
		} else {
			print_r($error);
			die();
		}
        $multi_files.=$new_name.',';
            }
        }else{
		$name = $files['name'];
		$size = $files['size'];
		$tempname = $files['tmp_name'];
		$type = $files['type'];
		$refrence = explode('.', $name);
		$file_exe = end($refrence);
		$extention =$img_ext;
		$new_name = time() . basename($name);
		$fileupload = "/" . $new_name;
		if (in_array($file_exe, $extention) === false) {
			$error[] = "please select valid iamge jpg or png";
		}
		if ($size > $img_size) {
			$error[] = "uploaded image 2MB or lower";
		}
		if (empty($error == true)) {
			move_uploaded_file($tempname, $fileupload);
		} else {
			print_r($error);
			die();
		}
        $multi_files.=$new_name;
    }
    return trim($multi_files,',');

    }
}


?>