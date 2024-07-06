<?php include('includes/header.php'); ?>
<?php if (!isLoggedIn()) { header("Location: login.php"); exit; } ?>

<?php
$id_buku = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $genre = $_POST['genre'];
    $stok = $_POST['stok'];

    $sql = "UPDATE buku SET judul = ?, penulis = ?, penerbit = ?, tahun = ?, genre = ?, stok = ? WHERE id_buku = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisi", $judul, $penulis, $penerbit, $tahun, $genre, $stok, $id_buku);
    if ($stmt->execute()) {
        header("Location: buku.php");
        exit;
    } else {
        $error = "Gagal mengedit buku.";
    }
} else {
    $sql = "SELECT * FROM buku WHERE id_buku = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_buku);
    $stmt->execute();
    $result = $stmt->get_result();
    $buku = $result->fetch_assoc();
}
?>

<h2>Edit Buku</h2>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<form action="edit_buku.php?id=<?php echo $id_buku; ?>" method="post">
    <div class="mb-3">
        <label for="judul" class="form-label">Judul</label>
        <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $buku['judul']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="penulis" class="form-label">Penulis</label>
        <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $buku['penulis']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="penerbit" class="form-label">Penerbit</label>
        <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo $buku['penerbit']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="tahun" class="form-label">Tahun</label>
        <input type="number" class="form-control" id="tahun" name="tahun" value="<?php echo $buku['tahun']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="genre" class="form-label">Genre</label>
        <input type="text" class="form-control" id="genre" name="genre" value="<?php echo $buku['genre']; ?>">
    </div>
    <div class="mb-3">
        <label for="stok" class="form-label">Stok</label>
        <input type="number" class="form-control" id="stok" name="stok" value="<?php echo $buku['stok']; ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Edit</button>
</form>

<?php include('includes/footer.php'); ?>
