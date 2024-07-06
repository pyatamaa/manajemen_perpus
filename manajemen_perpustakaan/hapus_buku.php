<?php include('includes/header.php'); ?>
<?php if (!isLoggedIn()) { header("Location: login.php"); exit; } ?>

<?php
$id_buku = $_GET['id'];

$sql = "DELETE FROM buku WHERE id_buku = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_buku);
if ($stmt->execute()) {
    header("Location: buku.php");
    exit;
} else {
    $error = "Gagal menghapus buku.";
}
?>

<?php include('includes/footer.php'); ?>
