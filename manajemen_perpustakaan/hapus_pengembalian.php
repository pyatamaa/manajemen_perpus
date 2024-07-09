<?php
session_start();
include('includes/config.php');
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}
include('includes/header.php');

$id_pengembalian = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    $sql = "DELETE FROM pengembalian WHERE id_pengembalian = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_pengembalian);
    if ($stmt->execute()) {
        header("Location: pengembalian.php");
        exit;
    } else {
        $error = "Gagal menghapus pengembalian.";
    }
}
?>

<h2>Hapus Pengembalian</h2>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php else: ?>
    <div class="alert alert-warning">
        <p>Apakah Anda yakin ingin menghapus pengembalian ini?</p>
        <form method="post" action="hapus_pengembalian.php?id=<?php echo $id_pengembalian; ?>">
            <button type="submit" name="confirm_delete" class="btn btn-danger">Hapus</button>
            <a href="pengembalian.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
<?php endif; ?>

<?php include('includes/footer.php'); ?>
