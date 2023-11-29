<?php
use MyApp\Connection;


// echo "<pre>";
// print_r($_POST);die();
// if(isset($_FILES)){
//     echo "<pre>";
//     print_r($_FILES);die;
//     }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['submit']){
            session_start();
            // echo "<pre>";
// print_r($_SESSION);die;
$con=mysqli_connect($_SESSION['crud']['h'],$_SESSION['crud']['u'],$_SESSION['crud']['p'],$_SESSION['crud']['d']);
$sql="SHOW FIELDS FROM {$_SESSION['crud']['t']}";
$result=mysqli_query($con,$sql);
    $db_params=mysqli_fetch_all($result,MYSQLI_ASSOC);
$params='';
foreach($db_params as $key=>$value){
    if($key == 'where'){
        continue;
    }
    if($key == 'submit'){
        continue;
    }
    if(array_key_exists($value['Field'],$_POST)){
        // print_r($value);die;
        $str='';
        if(str_contains($value['Type'],'(')){
          $str=strstr($value['Type'],"(",true);
        }else{
          $str=$value['Type'];
        }
    switch ($str) {
        case "text":
        case "char":
        case "varchar":
        case "mediumtext":
        case "tinytext":
        case "longtext":
        case "enum":
        case "set":
            $params.="{$value['Field']} = '{$_POST[$value['Field']]}', ";
          break;
        case "int":
        case "long":
        case "tintint":
        case "double":
        case "bigint":
        case "smallint":
        case "decimal":
        case "float":
        case "real":
            $params.=$value['Field'].' = '.$_POST[$value['Field']].', ';
          break;
        case "timestamp":
        case "date":
            $params.="{$value['Field']} = '{$_POST[$value['Field']]}', ";
          break;
      }
}
// $params.=$key.'='.$value." ,";
}
$new=trim($params,', ');
$sql1="UPDATE {$_SESSION['crud']['t']} SET {$new} WHERE {$_SESSION['crud']['id']}={$_POST['where']}";
if(mysqli_query($con,$sql1)){
    header("Location:../index");
}
// // $sql="SELECT * FROM {$_SESSION['crud']['t']} WHERE ";
// // $result=mysqli_query($con,$sql);
// // if(mysqli_num_rows($result)>0){
// //     $string="";
// //     foreach($data=mysqli_fetch_assoc($result) as $key=>$value){
// //         // $id=reset();
// //         $string.=$key."=".$value." , ";
// //     }
// //     $sql1="UPDATE {$_SESSION['crud']['t']} SET trim($string,',') WHERE {$_SESSION['crud']['id']}={$_POST['where']}";
// //     echo $sql1;die;
// //     if(mysqli_query($con,$sql1)){
// //         echo 1;
// //     }else{
// //         echo 2;
// //     }
    
// // }else{
// //     echo 3;
// // }

    }
}
?>