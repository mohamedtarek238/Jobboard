<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>


<?php 
 
 if(isset($_SESSION["type"]) AND $_SESSION["type"] !== "company"){
  header("location: ".APPURL."");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if($_SESSION['id'] !== $id){
      header(''.APPURL.'');
    }
    // Fetch user details
    $select = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $select->execute(['id' => $id]);
    $prfile = $select->fetch(PDO::FETCH_OBJ);


    $get_Applications = $conn->query("SELECT * FROM job_applications WHERE company_id = '$id'");
    $get_Applications->execute();
    $getApllication = $get_Applications->fetchAll(PDO::FETCH_OBJ); 

    if (!$prfile) {
        header("location:".APPURL."/404.php" );

    }
  }else{
    header("location:".APPURL."/404.php" );

  }


?>

<section class="section-hero overlay inner-page bg-image" style="background-image: url('<?php echo APPURL; ?>/images/hero_1.jpg');" id="home-section">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1 class="text-white font-weight-bold"><?php echo htmlspecialchars($prfile->username ?? 'Username'); ?></h1>
                <div class="custom-breadcrumbs">
                    <a href="<?php echo APPURL; ?>">Home</a>
                    <span class="mx-2 slash">/</span>
                    <span class="text-white"><strong><?php echo htmlspecialchars($prfile->username ?? 'Username'); ?></strong></span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="site-section">
    <div class="container">
        <ul class="job-listings mb-5">
          <?php foreach($getApllication AS $oneApplication): ?>
            <li class="d-block d-sm-flex pb-3 pb-sm-0 align-items-center">
                <div class="job-listing-logo">
                  <a style="text-decoration: none;" href="<?php echo APPURL; ?>/jobs/job-single.php?id=<?php echo $oneApplication->job_id; ?>">
                    <img 
                        src="user-images/<?php echo htmlspecialchars($_SESSION['image'] ?? 'default.png'); ?>" 
                        alt="User Image" 
                        class="img-fluid" 
                        style="max-width: 100px; max-height: 100px; object-fit: cover;">
                        </a>
                </div>

                <div class="d-sm-flex custom-width w-100 justify-content-between mx-4">
                    <div class="job-listing-position custom-width w-50 mb-3 mb-sm-0">
                        <h5><?php echo htmlspecialchars($oneApplication->job_title ?? 'Job Title'); ?></h5>
                        <strong></strong>
                    </div>

                    <div class="job-listing-meta">
                        <a style="text-decoration: none;" href="<?php echo APPURL; ?>/users/public-profile.php?id=<?php echo $oneApplication->worker_id; ?>" target="_blank">
                            <h5><?php echo htmlspecialchars($oneApplication->email  ?? 'Email'); ?></h5>
                        </a>
                    </div>

                    <div class="job-listing-meta">
                        <a 
                            class="btn btn-success text-white" 
                            href="<?php echo APPURL; ?>/users/user-cvs/<?php echo htmlspecialchars($oneApplication->cv ?? 'default.pdf'); ?>" 
                            role="button" 
                            download>
                            Download CV
                        </a>
                    </div>
                </div>
                <?php endforeach;?>
            </li>
        </ul>
    </div>
</section>

<?php require "../includes/footer.php"; ?>
