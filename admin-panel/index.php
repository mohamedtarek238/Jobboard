<?php require("../admin-panel/layouts/header.php"); ?>    
<?php require("../config/config.php"); ?>         
<?php

if(!isset($_SESSION['adminName'])){
  header("location:".ADMINURL."/admins/login-admins.php");
}


?>
<div class="container my-5">
  <div class="row text-center">
    <div class="col-md-4">
      <div class="card shadow border-primary">
        <div class="card-body">
          <h5 class="card-title text-primary">Jobs</h5>
          <p class="card-text">Number of jobs: <strong>8</strong></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow border-success">
        <div class="card-body">
          <h5 class="card-title text-success">Categories</h5>
          <p class="card-text">Number of categories: <strong>4</strong></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow border-info">
        <div class="card-body">
          <h5 class="card-title text-info">Admins</h5>
          <p class="card-text">Number of admins: <strong>3</strong></p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require("../admin-panel/layouts/footer.php"); ?>
