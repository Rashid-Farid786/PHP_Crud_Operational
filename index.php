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
     use MyApp\Crud;
     $con=new Crud("localhost","root","","testing");
      $con->settable("data");
      //  $con->instance();
      //  $con->pagination(3,4);
    //   $e=$con->insert(["name"=>"test","email"=>"test@gmail.com","password"=>"1234",]);
      //  echo "<pre>";
      //  print_r($e);
      $con->instance();
    ?>
</body>
</html>