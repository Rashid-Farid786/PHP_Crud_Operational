<?php
if (isset($_POST['up'])) {
  session_start();
  function tag($type, $name,$value,$reqiured)
  {
    if ($type == 'password') {
      return "<label class='form-label text-muted'>{$name}</label><br/>
        <input class='form-control' type='{$type}' name='{$name}' id='text' placeholder='{$name}' value ='{$value}' $reqiured/><br/>
        <label class='passbutton'>
		<input class='showpassword' type='checkbox' name='checkbox' onclick='toggle()'/>
		<span class='label ml-2'>show passwod</span>
		</label>";
    } else {
      return "<label class='form-label text-muted'>{$name}</label><br/><input class='form-control' type='{$type}' name='{$name}' placeholder='{$name}' value ='{$value}' $reqiured/><br/>";
    }
  }
  $con = mysqli_connect($_SESSION['crud']['h'], $_SESSION['crud']['u'], $_SESSION['crud']['p'], $_SESSION['crud']['d']);
  
  $sql = "SHOW FIELDS FROM {$_SESSION['crud']['t']}";
  $result = mysqli_query($con, $sql);
  $data = "
    <div class='modal fade show' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-modal='true' role='dialog' style='display: block;'>
    <div class='modal-dialog modal-dialog-scrollable' style='display:block;' role='document'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title'>Modal title</h5>
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true' onclick='model()'>&times;</span>
          </button>
        </div>
        <div class='modal-body'>
        <form action='src/update.php' name='form' method='post' class='form-group' anctype='multipart/form-data'>";
  if (mysqli_num_rows($result) > 0) {
    $e = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $sql1 = "SELECT * FROM {$_SESSION['crud']['t']} WHERE {$_SESSION['crud']['id']}={$_POST['up']}";
    $result1 = mysqli_query($con, $sql1);
    $fields=mysqli_fetch_row($result1);
    $count=1;
    foreach ($e as $key => $value) {
      if ($value['Field'] == "id") {
        continue;
      } else {
        switch (strstr($value['Type'], "(", true)) {
          case "text":
          case "char":
          case "varchar":
          case "mediumtext":
          case "tinytext":
            if (strtolower($value['Field']) == "password" || strtolower($value['Field']) == "pass") {
              $data .= tag("password", $value['Field'],$fields[$count],'');
            } else if (strtolower($value['Field']) == "email" || strtolower($value['Field']) == "mail") {
              $data .= tag("email", $value['Field'],$fields[$count],'');
            } else {
              $data .= tag("text", $value['Field'],$fields[$count],'');
            }
            break;
          case "longtext":
            $data .= tag("textaria", $value['Field'],$fields[$count],'');
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
            $data .= tag("number", $value['Field'],$value1,'');
            break;
          case "bolean":
            $data .= tag("text", $value['Field'],$value1,'');
            break;
          case "timestamp":
            break;
          case "date":
            $data .= tag("date", $value['Field'],$value1,'');
          case "enum":
          case "set":
            $data .= "<select class='form-control' name='{$value['Field']}' required>
                  <option value='0'>false</option>
                  <option value='1'>True</option>
                  </select>";
          // default:
          // $data.="<input type='not' name='not'/>";
          // break;
        }
      }
      $count++;
  }
  }
  $data .= "<br/><div class='text-center'><input type='submit' class='btn btn-primary' value='submit' name='submit'/></div></form></div>
    <div class='modal-footer'>
      <button type='button' class='btn btn-secondary' data-dismiss='modal' onclick='model()'>Close</button>
    </div>
    </div>
    </div>
    </div>
    <div class='modal-backdrop fade show'></div>";
  echo $data;
}


?>