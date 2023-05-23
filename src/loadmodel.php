<?php
if(isset($_POST['up'])){
    session_start();
    $con=mysqli_connect($_SESSION['crud']['h'],$_SESSION['crud']['u'],$_SESSION['crud']['p'],$_SESSION['crud']['d']);
    $sql="SELECT * FROM {$_SESSION['crud']['t']} WHERE {$_SESSION['crud']['id']}={$_POST['up']}";
    $result=mysqli_query($con,$sql);
    $data="
        <div class='modal' tabindex='-1' role='dialog'>
          <div class='modal-dialog' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title'>Modal title</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>";
    if(mysqli_num_rows($result)>0){
        while(mysqli_fetch_assoc($result)){
            $data.="<p>Modal body text goes here.</p>";
        }
    }
    $data.="</div>
    <div class='modal-footer'>
      <button type='button' class='btn btn-primary'>Save changes</button>
      <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
    </div>
  </div>
</div>
</div>";
echo $data;
    }


?>