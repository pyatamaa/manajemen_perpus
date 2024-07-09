<?php
session_start();
include('includes/config.php');
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}
include('includes/header.php');

$id_buku = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    $sql = "DELETE FROM buku WHERE id_buku = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_buku);
    if ($stmt->execute()) {
        header("Location: buku.php");
        exit;
    } else {
        $error = "Gagal menghapus buku.";
    }
}
?>

<h2>Hapus Buku</h2>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php else: ?>
    <div class="alert alert-warning">
        <p>Apakah Anda yakin ingin menghapus buku ini?</p>
        <form method="post" action="hapus_buku.php?id=<?php echo $id_buku; ?>">
            <button type="submit" name="confirm_delete" class="btn btn-danger">Hapus</button>
            <a href="buku.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
<?php endif; ?>

<?php include('includes/footer.php'); ?>
