<?php
// echo "<pre>";
// print_r($_POST);die();
if($_POST['submit']){
    // if(){}
    session_start();
 extract($_POST);
 $keys=trim(str_replace('submit','',implode(",",array_keys($_POST))),',');
 $values="";
 foreach($_POST as $key=>$value){
     // store array values in values variable
     if($key == 'submit'){
        continue;
     }else{
         $values.="'".$value."',";
    }
 }
 $con = mysqli_connect($_SESSION['crud']['h'], $_SESSION['crud']['u'], $_SESSION['crud']['p'], $_SESSION['crud']['d']);
 $val=trim($values,',');
$sql="INSERT INTO {$_SESSION['crud']['t']} ({$keys}) VALUES({$val})";
 $e=mysqli_query($con,$sql);
 if(!mysqli_error($con)){
     return true;
 }else{
     return false;
 }
}else{
    return false;
}
?>