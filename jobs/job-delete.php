
<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php 


if(isset($_GET["id"])){
$id= $_GET['id'];

$delete = $conn->prepare("DELETE FROM jobs WHERE id = '$id'");
$delete->execute();
header("location:".APPURL."");
}else{
    header("location:".APPURL."/404.php" );

}

?>



<?php require "../includes/footer.php"; ?>
