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
    use MyApp\Game\Player\Player;
    use MyApp\Game\GameController;
    $player=new Player();
    $gameController=new GameController();
    ?>
</body>
</html>