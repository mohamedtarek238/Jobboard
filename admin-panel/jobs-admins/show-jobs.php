<?php require("../../config/config.php"); ?>
<?php require("../layouts/header.php"); ?>

<?php 
if(!isset($_SESSION['adminName'])){
  header("location:".ADMINURL."/admins/login-admins.php");
}


$select = $conn->query("SELECT * FROM jobs");
$select->execute();
$jobs = $select->fetchAll(PDO::FETCH_OBJ);

?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title mb-4 text-center">Jobs</h5>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="table-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Job Title</th>
                  <th scope="col">Category</th>
                  <th scope="col">Company</th>
                  <th scope="col">Status</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($jobs AS $job): ?>
                    <tr>
                      <th scope="row"><?php echo $job->id ?></th>
                      <td><?php echo $job->job_title ?></td>
                      <td><?php echo $job->job_category ?></td>
                      <td><?php echo $job->company_name ?></td>
                      <?php if($job->status == 1): ?>
                      <td>
                        <a href="<?php echo ADMINURL ?>/jobs-admins/status-jobs.php?id=<?php echo $job->id ?>&status=<?php echo $job->status ?>" class="btn btn-sm btn-success">Verified</a>
                      </td>
                      <?php else: ?>
                      <td>
                        <a href="<?php echo ADMINURL ?>/jobs-admins/status-jobs.php?id=<?php echo $job->id ?>&status=<?php echo $job->status ?>" class="btn btn-sm btn-warning">Unverified</a>
                      </td>
                      <?php endif;  ?>

                      <td>
                        <a href="<?php echo ADMINURL ?>/jobs-admins/delete-jobs.php?id=<?php echo $job->id ?>" class="btn btn-sm btn-danger">Delete</a>
                      </td>
                    </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require("../layouts/footer.php"); ?>
