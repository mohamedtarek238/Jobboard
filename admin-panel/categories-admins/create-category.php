<?php require("../../config/config.php"); ?>
<?php require("../layouts/header.php"); ?>

<?php 
// Check if the form was submitted
if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);

    // Validate input
    if (empty($name)) {
        echo "<script>alert('Category name cannot be empty');</script>";
    } else {
        try {
            // Prepare the SQL query
            $insert = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
            $insert->execute([
                ":name" => $name
            ]);

            // Redirect to the categories list
            header("Location: ".ADMINURL."/categories-admins/show-categories.php");
            exit();
        } catch (PDOException $e) {
            // Handle database errors
            echo "<script>alert('Error: Unable to create category');</script>";
        }
    }
}
?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-lg">
        <div class="card-body">
          <h5 class="card-title mb-4 text-center">Create Categories</h5>
          <form method="POST" action="create-category.php" enctype="multipart/form-data">
            <!-- Category Name Input -->
            <div class="form-group mb-4">
              <label for="categoryName" class="form-label">Category Name</label>
              <input 
                type="text" 
                name="name" 
                id="categoryName" 
                class="form-control" 
                placeholder="Enter category name" 
                required 
              />
            </div>

            <!-- Submit Button -->
            <div class="text-center">
              <button type="submit" name="submit" class="btn btn-success btn-block">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require("../layouts/footer.php"); ?>
