<?php
namespace MyApp;
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


?>