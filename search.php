
<?php require("config/config.php"); ?>

<?php require("../jobboard/includes/header.php");?>


<?php

  
 if(isset($_POST['submit'])){

    if(empty($_POST['job-title']) OR empty($_POST['job-region']) OR empty($_POST['job-type'])){
    header("location:".APPURL."");
        
    }else{
        $job_title = $_POST['job-title'];
        $job_region = $_POST['job-region'];
        $job_type = $_POST['job-type'];

        $insert = $conn->prepare("INSERT INTO searches (keyword) VALUES (:keyword)");
        $insert->execute([
            ":keyword"=>$job_title,
        ]);

        $search = $conn->query("SELECT * FROM jobs WHERE job_title LIKE '%$job_title%' AND job_region LIKE '%$job_region%' AND job_type LIKE '%$job_type%' AND status = 1 ");
        $search->execute();
        $result = $search->fetchAll(PDO::FETCH_OBJ);



    }


 }else{
    header("location:".APPURL."");
 }


?>

<section class="section-hero overlay inner-page bg-image" style="background-image: url('<?php echo APPURL; ?>/images/hero_1.jpg');" id="home-section">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1 class="text-white font-weight-bold">Search Results For</h1>
                <div class="custom-breadcrumbs">
                    <a href="<?php echo APPURL; ?>">Home</a> <span class="mx-2 slash">/</span>
                    <span class="text-white">Search</strong></span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="site-section">
      <div class="container">
        <ul class="job-listings mb-5">
            <?php if(count($result) > 0): ?>
         
                    <?php foreach($result as $oneJob):?>                 
                
                    <li class="job-listing d-block d-sm-flex pb-3 pb-sm-0 align-items-center">
                        <a href="<?php echo APPURL; ?>/jobs/job-single.php?id=<?php echo $oneJob->id ?>"></a>
                        <div class="job-listing-logo">
                        <img src="users/user-images/<?php echo $oneJob->company_image ;?>" alt="Free Website Template by Free-Template.co" class="img-fluid">
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
            <?php else:?>
                <div class="alert alert-danger bg-danger text-white" >there are no results </div>
            <?php endif; ?>
          
        </ul>

  

      </div>
    </section>


<?php require("../jobboard/includes/footer.php");?>
