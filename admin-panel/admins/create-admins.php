<?php require("../../config/config.php"); ?>       
<?php require("../layouts/header.php"); ?>     

<?php
if(!isset($_SESSION['adminName'])){
  header("location:".ADMINURL."/admins/login-admins.php");
}

// if (isset($_SESSION['adminName'])) {
//   header("location:" . ADMINURL . "");
// }

if (isset($_POST["submit"])) {
  $adminName = htmlspecialchars($_POST['adminName']);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $mypassword = htmlspecialchars($_POST['mypassword']);

  if (empty($adminName) || empty($mypassword) || empty($email)) {
    $message = "All fields are required.";
    $messageType = "danger";
  } elseif (strlen($email) > 50 || strlen($adminName) > 30) {
    $message = "Email or admin name exceeds allowed length.";
    $messageType = "danger";
  } else {
    $validate = $conn->prepare("SELECT * FROM admins WHERE email = :email OR adminName = :adminName");
    $validate->execute([':email' => $email, ':adminName' => $adminName]);

    if ($validate->rowCount() > 0) {
      $message = "Email or admin name is already taken.";
      $messageType = "danger";
    } else {
      $insert = $conn->prepare("INSERT INTO admins (adminName, email, mypassword) VALUES (:adminName, :email, :mypassword)");
      $insert->execute([
        ':adminName' => $adminName,
        ':email' => $email,
        ':mypassword' => password_hash($mypassword, PASSWORD_DEFAULT)
      ]);

      $message = "Admin created successfully. Redirecting to login...";
      $messageType = "success";
      echo "<script>setTimeout(function() { window.location.href = '" . ADMINURL . "/admins/login-admins.php'; }, 2000);</script>";
    }
  }
}
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-body">
          <h5 class="card-title text-center mb-4">Create Admin</h5>

          <!-- Display Messages -->
          <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $messageType; ?> text-center">
              <?php echo $message; ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="" enctype="multipart/form-data">
            <!-- Email input -->
            <div class="form-outline mb-4">
              <label for="email" class="form-label">Email</label>
              <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control" 
                placeholder="Enter email" 
                maxlength="50"
                required />
            </div>

            <!-- Username input -->
            <div class="form-outline mb-4">
              <label for="adminName" class="form-label">Admin Name</label>
              <input 
                type="text" 
                name="adminName" 
                id="adminName" 
                class="form-control" 
                placeholder="Enter admin name" 
                maxlength="30"
                required />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <label for="mypassword" class="form-label">Password</label>
              <input 
                type="password" 
                name="mypassword" 
                id="mypassword" 
                class="form-control" 
                placeholder="Enter password" 
                minlength="6"
                required />
            </div>

            <!-- Submit button -->
            <div class="text-center">
              <button 
                type="submit" 
                name="submit" 
                class="btn btn-primary btn-block">
                <i class="fas fa-user-plus"></i> Create Admin
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require("../layouts/footer.php"); ?>
