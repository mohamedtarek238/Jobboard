<?php require("../../config/config.php"); ?>
<?php require("../layouts/header.php"); ?>

<?php 

if(isset($_GET["id"])){
  $id= $_GET['id'];

  $select = $conn->query("SELECT  * FROM categories WHERE id = '$id'");
  $select->execute();
  $category = $select->fetch(PDO::FETCH_OBJ);
}else{
    header("location:".APPURL."/404.php" );
}

if (isset($_POST['submit'])) {
  $name = trim($_POST['name']);

  // Validate input
  if (empty($name)) {
      echo "<script>alert('Category name cannot be empty');</script>";
  } else {
      try {
          // Prepare the SQL query
          $update = $conn->prepare(" UPDATE categories SET name = :name WHERE id = '$id'");
          $update->execute([
              ":name" => $name
          ]);

          // Redirect to the categories list
          header("Location: ".ADMINURL."/categories-admins/show-categories.php");
          exit();
      } catch (PDOException $e) {
          // Handle database errors
          echo "<script>alert('Error: Unable to update category');</script>";
      }
  }
}
?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title mb-4 text-center">Update Categories</h5>
          <form method="POST" action="update-category.php?id=<?php echo $id ?>" enctype="multipart/form-data">
            <!-- Category Name Input -->
            <div class="form-group mb-4">
              <label for="categoryName" class="form-label">Category Name</label>
              <input 
                type="text"  
                value="<?php echo $category->name ?>"
                name="name" 
                id="categoryName" 
                class="form-control" 
                placeholder="<?php echo $category->name ?>" 
                required
              />
            </div>

            <!-- Submit Button -->
            <div class="text-center">
              <button type="submit" name="submit" class="btn btn-primary btn-block">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require("../layouts/footer.php"); ?>
