<?php require("../../config/config.php"); ?>       
<?php require("../layouts/header.php"); ?>         
<?php

if(!isset($_SESSION['adminName'])){
  header("location:".ADMINURL."/admins/login-admins.php");
}


$select = $conn->query("SELECT * FROM admins");
$select->execute();
$admins = $select->fetchAll(PDO::FETCH_OBJ);

?>

<div class="container my-5">
  <div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">Admins</h5>
            <a href="<?php echo ADMINURL; ?>/admins/create-admins.php" class="btn btn-primary">
              <i class="fas fa-user-plus"></i> Create Admin
            </a>
          </div>
          <table class="table table-hover table-striped">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($admins as $admin): ?>
              <tr>
                <th scope="row"><?php echo $admin->id; ?></th>
                <td><?php echo $admin->adminName; ?></td>
                <td><?php echo $admin->email; ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table> 
        </div>
      </div>
    </div>
  </div>
</div>

<?php require("../layouts/footer.php"); ?>
