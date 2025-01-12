<?php require("../config/config.php"); ?>

<?php require("../includes/header.php"); ?>

<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $select = $conn->query("SELECT * FROM users WHERE id ='$id'");
    $select->execute();
    $prfile = $select->fetch(PDO::FETCH_OBJ);


    //jobs created by the company

    $jobs = $conn->query("SELECT * FROM jobs WHERE company_id = '$id' AND status = 1 LIMIT 5 ");
    $jobs->execute();
    $moreJobs=$jobs->fetchAll(PDO::FETCH_OBJ);
} else {
  header("location:".APPURL."/404.php" );

}

?>
<section class="section-hero overlay inner-page bg-image" style="background-image: url('<?php echo APPURL; ?>/images/hero_1.jpg');" id="home-section">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1 class="text-white font-weight-bold"><?php echo $prfile->username; ?></h1>
                <div class="custom-breadcrumbs">
                    <a href="<?php echo APPURL; ?>">Home</a> <span class="mx-2 slash">/</span>
                    <span class="text-white"><strong><?php echo $prfile->username; ?></strong></span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="site-section" id="home-section">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-7">
                <div class="card p-3 py-4">

                    <div class="text-center">
                        <img src="user-images/<?php echo $prfile->img; ?>" width="100" class="rounded-circle">
                    </div>

                    <div class="text-center mt-3">
                        <?php if (isset($_SESSION['type']) and $_SESSION['type'] == 'worker'): ?>
                            <a    class="btn btn-success text-white" 
                            href="<?php echo APPURL; ?>/users/user-cvs/<?php echo htmlspecialchars($prfile->cv ?? 'default.pdf'); ?>" 
                            role="button" 
                            download>
                            Download CV</a>
                        <?php endif; ?>
                        <h5 class="mt-2 mb-0"><?php echo $prfile->username; ?></h5>
                        <?php if (isset($_SESSION['type']) and $_SESSION['type'] == 'worker'): ?>

                            <span><?php echo $prfile->title; ?></span>
                        <?php endif; ?>

                        <div class="px-4 mt-1">
                            <p class="fonts"><?php echo $prfile->bio; ?></p>

                        </div>

                        <div class="px-3">
                            <a href="<?php echo $prfile->facebook; ?>" class="pt-3 pb-3 pr-3 pl-0 underline-none"><span class="icon-facebook"></span></a>
                            <a href="<?php echo $prfile->twitter; ?>" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-twitter"></span></a>
                            <a href="<?php echo $prfile->linkedin; ?>" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-linkedin"></span></a>
                        </div>



                    </div>




                </div>
            </div>
        </div>


    </div>
</section>
<section class="site-section">
      <div class="container">
              <?php  if(isset($_SESSION['type']) AND $_SESSION['type'] == 'company' AND $_SESSION['id'] == $id): ?>

        <div class="row mb-5 justify-content-center">
          <div class="col-md-7 text-center">
            <h2 class="section-title mb-2">Jobs Posted By This Company</h2>
          </div>
        </div>
        <?php endif; ?>
        
        <ul class="job-listings mb-5">
         
         <?php foreach($moreJobs as $oneJob):?>                 
       
          <li class="job-listing d-block d-sm-flex pb-3 pb-sm-0 align-items-center">
            <a href="<?php echo APPURL; ?>/jobs/job-single.php?id=<?php echo $oneJob->id ?>"></a>
            <div class="job-listing-logo">
              <img src="user-images/<?php echo $oneJob->company_image ;?>" alt="Free Website Template by Free-Template.co" class="img-fluid">
            </div>

       

            <div class="job-listing-about d-sm-flex custom-width w-100 justify-content-between mx-4">
              <div class="job-listing-position custom-width w-50 mb-3 mb-sm-0">
                <h2><?php echo $oneJob->company_name?></h2>
                <strong><?php echo $oneJob->job_title;  ?></strong>
              </div>
              <div class="job-listing-location mb-3 mb-sm-0 custom-width w-25">
                <span class="icon-room"></span> <?php echo $oneJob->job_region ?>
              </div>
              <div class="job-listing-meta">
                <span class="badge badge-<?php if($oneJob->job_type == 'Full Time'){echo 'success';}else{ echo 'danger';}?>"><?php echo $oneJob->job_type ?></span>
              </div>
            </div>
          </li>
          
          <?php endforeach ?>

          
        </ul>

  

      </div>
    </section>

<?php require("../includes/footer.php"); ?>