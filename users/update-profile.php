<?php require("../config/config.php"); ?>

<?php require("../includes/header.php"); ?>

<?php


if (!isset($_SESSION['username'])) {
  header("location:" .APPURL. "");
}
if ($_SESSION['id'] != $_GET['upd_id']) {
  header("location:" . APPURL . "");
}

if (isset($_GET['upd_id'])) {
  $id = $_GET['upd_id'];
  
  


  $select = $conn->query("SELECT * FROM users WHERE id ='$id'");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  if (empty($_POST['username']) OR empty($_POST['email'])) {
    echo "<script>alert('Some inputs are empty')  </script>";
  } else {

    $username = $_POST["username"];
    $email = $_POST["email"];
    $title = $_POST["title"];
    $bio = $_POST["bio"];
    $facebook = $_POST["facebook"];
    $twitter = $_POST["twitter"];
    $linkedin = $_POST["linkedin"];
    $img = $_FILES["img"]['name'];
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == UPLOAD_ERR_OK) {
      $cv = $_FILES['cv']['name'];
  } else {
      $cv = $row->cv ?? 'NULL'; // Use existing CV or set to 'NULL'
  }

    $dir_img = 'user-images/' . basename($img);
    $dir_cv = 'user-cvs/' . basename($cv);

    $update = $conn->prepare("UPDATE users SET username = :username, email = :email, title = :title, bio = :bio, facebook = :facebook, twitter = :twitter, linkedin = :linkedin, img = :img, cv = :cv WHERE id = '$id'");


    if($img!=='' AND $cv !== ''){

      $row->type == "worker" ? $cv = $_FILES['cv']['name'] : $cv= 'NULL';

      unlink("user-images/".$row->img."");
      if (!empty($row->cv) && file_exists("user-cvs/" . $row->cv)) {
        unlink("user-cvs/" . $row->cv);
    }

      $update->execute([
        ':username' =>$username,
        ':email' =>$email,
        ':title' =>$title,
        ':bio' =>$bio,
        ':facebook' =>$facebook,
        ':twitter' =>$twitter,
        ':linkedin' =>$linkedin,
        ':img' =>$img,
        ':cv' =>$cv,
       ]);
    }else{
      $update->execute([
        ':username' =>$username,
        ':email' =>$email,
        ':title' =>$title,
        ':bio' =>$bio,
        ':facebook' =>$facebook,
        ':twitter' =>$twitter,
        ':linkedin' =>$linkedin,
        ':img' =>$row->img,
        ':cv' =>$row->cv,
       ]);
    }

   

    if (isset($_FILES['img']) && $_FILES['img']['error'] == UPLOAD_ERR_OK) {
      move_uploaded_file($_FILES['img']['tmp_name'], $dir_img);
  }
  
  if (isset($_FILES['cv']) && $_FILES['cv']['error'] == UPLOAD_ERR_OK) {
      move_uploaded_file($_FILES['cv']['tmp_name'], $dir_cv);
  }
  header("location:" . APPURL . "");
  }
} else {
  header("location:".APPURL."/404.php" );

}

?>

<!-- HOME -->
<section class="section-hero overlay inner-page bg-image" style="background-image: url('../images/hero_1.jpg');" id="home-section">
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        <h1 class="text-white font-weight-bold">Update Profile</h1>
        <div class="custom-breadcrumbs">
          <a href="<?php echo APPURL; ?>">Home</a> <span class="mx-2 slash">/</span>
          <span class="text-white"><strong>Update Profile</strong></span>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="site-section" id="next-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mb-5 mb-lg-0">
        <form action="update-profile.php?upd_id=<?php echo $id ?>" method="POST" class="" enctype=multipart/form-data>

          <div class="row form-group">
            <div class="col-md-6 mb-3 mb-md-0">
              <label class="text-black" for="fname">UserName</label>
              <input type="text" id="fname" value="<?php echo $row->username ?>" name="username" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="text-black" for="lname">Email</label>
              <input type="email" id="lname" name="email" value="<?php echo $row->email ?>" class="form-control">
            </div>
          </div>
          <?php if (isset($_SESSION['type']) and $_SESSION['type'] == 'worker'): ?>

            <div class="row form-group">

              <div class="col-md-12">
                <label class="text-black" for="email">Title</label>
                <input type="text" id="" name="title" value="<?php echo $row->title ?>" class="form-control">
              </div>
            </div>
          <?php else: ?>
            <div class="row form-group">

                  <div class="col-md-12">
                    <input type="hidden" id="" name="title" value="NULL" class="form-control">
                  </div>
            </div>
            <?php endif; ?>
          <!-- <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black" for="subject">Subject</label> 
                  <input type="subject" id="subject" class="form-control">
                </div>
              </div> -->

          <div class="row form-group">
            <div class="col-md-12">
              <label class="text-black" for="message">Bio</label>
              <textarea name="bio" id="" cols="30" rows="7" class="form-control" placeholder="<?php echo $row->bio ?>"></textarea>
            </div>
          </div>
          <div class="row form-group">

            <div class="col-md-12">
              <label class="text-black" for="subject">Facebook</label>
              <input type="subject" name="facebook" id="subject" class="form-control">
            </div>
          </div>
          <div class="row form-group">

            <div class="col-md-12">
              <label class="text-black" for="subject">Twitter</label>
              <input type="subject" name="twitter" id="subject" class="form-control">
            </div>
          </div>
          <div class="row form-group">

            <div class="col-md-12">
              <label class="text-black" for="subject">Linkedin</label>
              <input type="subject" name="linkedin" id="subject" class="form-control">
            </div>
          </div>
          <div class="row form-group">

            <div class="col-md-12">
              <label class="text-black" for="subject">Image</label>
              <input type="file" name="img" id="subject" class="form-control">
            </div>
          </div>
          <?php if (isset($_SESSION['type']) and $_SESSION['type'] == 'worker'): ?>
            <div class="row form-group">

              <div class="col-md-12">
                <label class="text-black" for="subject">CV</label>
                <input type="file" name="cv" id="subject" class="form-control">
              </div>
            </div>
          <?php else: ?>
          <div class="row form-group">

              <div class="col-md-12">
                
              <input type="hidden" name="cv" value="">

              </div>
            </div>
            <?php endif; ?>

          <div class="row form-group">
            <div class="col-md-12">
              <input type="submit" name="submit" value="Update" class="btn btn-primary btn-md text-white">
            </div>
          </div>


        </form>
      </div>

    </div>
  </div>
</section>



<?php require("../includes/footer.php"); ?>