
<?php require("../../config/config.php"); ?>
<?php require("../layouts/header.php"); ?>

<?php




if(isset($_GET["id"])){
$id= $_GET['id'];

$delete = $conn->prepare("DELETE FROM categories WHERE id = '$id'");
$delete->execute();
header("location:".ADMINURL."");
}else{
    header("location:".APPURL."/404.php" );

}




?>


<?php require("../layouts/footer.php"); ?>