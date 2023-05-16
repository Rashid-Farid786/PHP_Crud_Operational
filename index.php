<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
     include_once realpath("vendor/autoload.php");
     use MyApp\Connection;
     $con=new Connection("localhost","root","","testing");
     $con->settable("data");
     $con->pagination(3,4);
     $con->instance();
    //  echo $con->pagination;
    //  if($con->pagination){
    //     echo "pagination false";
    //  }else{
    //     echo "Pagination True";
    //  }
    
    // $r=$con->insert(array("name"=>"rashid farid","email"=>"test@gmail.com","password"=>"1234"));
    // echo "<pre>";
    // print_r($r);
    ?>
</body>
</html>