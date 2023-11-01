<?php
namespace MyApp;
include_once "Error.php";
use MyApp\Error;
class ErrorResponse{
    public $status;
    public $message;
    public $error;
    public $data;
    public function __construct(bool $status,string $message,string $error,array $data){
        // parent::__construct();
        $this->status=$status;
        $this->message=$message;
        $this->error=$error;
        $this->data=$data;
        // new Error();
    }
}



?>