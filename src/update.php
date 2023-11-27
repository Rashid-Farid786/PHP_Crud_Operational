<?php
// echo "<pre>";
// print_r($_POST);die();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST['submit']){
session_start();
// echo "<pre>";
// print_r($_SESSION);die;
$con=mysqli_connect($_SESSION['crud']['h'],$_SESSION['crud']['u'],$_SESSION['crud']['p'],$_SESSION['crud']['d']);
$params='';
foreach($_POST as $key=>$value){
    if($key == 'where'){
        continue;
    }
    if($key == 'submit'){
        continue;
    }
$params.=$key.'='.$value." ,";
}
$new=trim($params,',');
$sql="UPDATE {$_SESSION['crud']['t']} SET {$new} WHERE {$_SESSION['crud']['id']}={$_POST['where']}";
echo $sql;die;
if(mysqli_query($con,$sql)){
    header("Location:../index");
}
// $sql="SELECT * FROM {$_SESSION['crud']['t']} WHERE ";
// $result=mysqli_query($con,$sql);
// if(mysqli_num_rows($result)>0){
//     $string="";
//     foreach($data=mysqli_fetch_assoc($result) as $key=>$value){
//         // $id=reset();
//         $string.=$key."=".$value." , ";
//     }
//     $sql1="UPDATE {$_SESSION['crud']['t']} SET trim($string,',') WHERE {$_SESSION['crud']['id']}={$_POST['where']}";
//     echo $sql1;die;
//     if(mysqli_query($con,$sql1)){
//         echo 1;
//     }else{
//         echo 2;
//     }
    
// }else{
//     echo 3;
// }

    }
}
?>