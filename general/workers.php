
<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

 $selectWorkers = $conn->query("SELECT * FROM users WHERE type= 'worker' ");
 $selectWorkers->execute();
 $AllWorkers = $selectWorkers->fetchAll(PDO::FETCH_OBJ);


?>

<!-- HOME -->
    <section class="section-hero overlay inner-page bg-image" style="background-image: url('<?php echo APPURL; ?>/images/hero_1.jpg');" id="home-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h1 class="text-white font-weight-bold">Workers</h1>
                    <div class="custom-breadcrumbs">
                        <a href="<?php echo APPURL; ?>">Home</a> <span class="mx-2 slash">/</span>
                        <span class="text-white"><strong>Workers</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="site-section" id="home-section">
        <div class="container">
            <div class="row ">
                <?php foreach($AllWorkers AS $Worker):?>
                <div class="col-md-6 ">
                    <div class="card" style="width: 18rem;">
                    <img class="card-img-top" style="height: 200px;" src="../users/user-images/<?php echo $Worker->img ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $Worker->username ?></h5>
                            <p class="card-text"><?php echo substr($Worker->bio,0,50) ?></p>
                            <a target="_blank" href="../users/public-profile.php?id=<?php echo $Worker->id ?>" class="btn btn-primary">Go To Profile </a>
                        </div>
                    </div>
                    <br>

                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

<?php require "../includes/footer.php"; ?>
