<?php
session_start();
function tag($type, $name,$reqiured,$cat)
{
    if($reqiured=='NO'){
        $requre='required';
      }else{
        $requre='';
      }
      $repname=str_replace('-',' ',str_replace('_',' ',$name));
      $symble='';
      if($reqiured == "NO"){
        $symble='<span class="red">*</span>';
      }else{
        $symble='<span class="gray">(Optional)</span>';
      }
      if ($type == 'password') {
        return "<label class='form-label text-muted'>{$repname} {$symble}</label><br/>
          <input class='form-control' type='{$type}' name='{$name}' id='text' placeholder='{$repname}' $requre/><br/>
          <label class='passbutton'>
          <input class='showpassword' type='checkbox' name='checkbox' onclick='toggle()'/>
          <span class='label ml-2'>show passwod</span>
          </label>";
      }else if($type == 'select'){
        $i=explode(",",str_replace(array('set(','enum(',')',"'"),'',$cat));
        $s = "
              <label class='form-label text-muted'>{$repname} {$symble}</label>
              <select class='form-control' name='{$name}' required>";
                    foreach($i as $val){
                $s.="<option value='{$val}'>{$val}</option>";
                    }
                    $s.="</select><br/>";
                    return $s;
      }else if($type == "date"){
        return "<label class='form-label text-muted'>{$repname}  {$symble}</label><br/><input class='form-control' type='{$type}' name='{$name}' placeholder='{$repname}' $requre/><br/>";
      }else if($type == 'file'){
        return "<div classs='img-box'><label class='form-label text-muted'>{$repname}  {$symble}</label><br/><input class='form-control' type='{$type}' name='{$name}[]' accept='image/*' multiple $requre/>
        <img src='' alt='' class='img-fluid'/>
        </div><br/>";
      }else {
        return "<label class='form-label text-muted'>{$repname} {$symble}</label><br/><input class='form-control' type='{$type}' name='{$name}' placeholder='{$repname}' $requre/><br/>";
      }
}
$con = mysqli_connect($_SESSION['crud']['h'], $_SESSION['crud']['u'], $_SESSION['crud']['p'], $_SESSION['crud']['d']);
$sql = "SHOW FIELDS FROM {$_SESSION['crud']['t']}";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    $data="
    <div class='modal fade show' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-modal='true' role='dialog' style='display: block;'>
          <div class='modal-dialog modal-dialog-scrollable' style='display:block;' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title'>Add Form</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true' onclick='model()'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
              <form action='src/insert.php' name='form' method='post' class='form-group' enctype='multipart/form-data'>";
    $e = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // echo "<pre>";
    // print_r($e);die;
    foreach ($e as $key => $value) {
            if($value['Field'] == "id"){
                continue;
            }else{
              $str='';
              if(str_contains($value['Type'],'(')){
                $str=strstr($value['Type'],"(",true);
              }else{
                $str=$value['Type'];
              }
        switch($str){
            case "text":
            case "char":
            case "varchar":
            case "mediumtext":
            case "tinytext":
              if(str_contains($value['Field'],'img')){
                $data.=tag("file", $value['Field'],$value['Null'],$value['Type']);
              }else{
                if(strtolower($value['Field']) == "password" || strtolower($value['Field']) == "pass"){
                    $data.=tag("password", $value['Field'],$value['Null'],$value['Type']);
                }else if(strtolower($value['Field']) == "email" || strtolower($value['Field']) == "mail"){
                    $data.=tag("email", $value['Field'],$value['Null'],$value['Type']);
                }else{
                    $data.=tag("text", $value['Field'],$value['Null'],$value['Type']);
                }
              }
                break;
            case "longtext":
                $data.=tag("textaria", $value['Field'],$value['Null'],$value['Type']);
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
                $data.=tag("number", $value['Field'],$value['Null'],$value['Type']);
                break;
                case "timestamp":
                    $data.=tag("date", $value['Field'],$value['Null'],$value['Type']);
                break;
                case "date":
                    $data.=tag("date", $value['Field'],$value['Null'],$value['Type']);
                    break;
            case "enum":
            case "set":
                $data .= tag("select", $value['Field'],$value['Null'],$value['Type']);
                break;
                case "bolean":
                  $data.=tag("text", $value['Field'],$value['Null'],$value['Type']);
                  break;
                // default:
                // $data.="<input type='not' name='not'/>";
                // break;
        }
    }
}
$data.="<br/><div class='text-center'><input type='submit' class='btn btn-primary' value='submit' name='submit'/></div></form></div>
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