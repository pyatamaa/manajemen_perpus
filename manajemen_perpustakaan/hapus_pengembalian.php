<?php include('includes/header.php'); ?>
<?php if (!isLoggedIn()) { header("Location: login.php"); exit; } ?>

<?php
$id_pengembalian = $_GET['id'];

$sql = "DELETE FROM pengembalian WHERE id_pengembalian = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pengembalian);
if ($stmt->execute()) {
    header("Location: pengembalian.php");
    exit;
} else {
    $error = "Gagal menghapus pengembalian.";
}
?>

<?php include('includes/footer.php'); ?>
