<?php
namespace MyApp;
class Testing{
    public function __construct(){
        $db_name="mysql:host=ocalhost;dbname=testing";
       $con= new mysqli("localhost","root","","testing");
       print_r($con);
    }
}


?>