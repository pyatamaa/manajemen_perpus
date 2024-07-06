<?php include('includes/header.php'); ?>
<?php if (!isLoggedIn()) { header("Location: login.php"); exit; } ?>

<?php
$id_peminjaman = $_GET['id'];

$sql = "DELETE FROM peminjaman WHERE id_peminjaman = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_peminjaman);
if ($stmt->execute()) {
    header("Location: peminjaman.php");
    exit;
} else {
    $error = "Gagal menghapus peminjaman.";
}
?>

<?php include('includes/footer.php'); ?>
