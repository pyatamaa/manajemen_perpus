<?php
session_start();
include('includes/config.php');
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}
include('includes/header.php');
?>

<?php
$id_peminjaman = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_buku = $_POST['id_buku'];
    $nama_peminjam = $_POST['nama_peminjam'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_jatuh_tempo = $_POST['tanggal_jatuh_tempo'];
    $status = $_POST['status'];

    $sql = "UPDATE peminjaman SET id_buku = ?, nama_peminjam = ?, tanggal_pinjam = ?, tanggal_jatuh_tempo = ?, status = ? WHERE id_peminjaman = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssi", $id_buku, $nama_peminjam, $tanggal_pinjam, $tanggal_jatuh_tempo, $status, $id_peminjaman);
    if ($stmt->execute()) {
        header("Location: peminjaman.php");
        exit;
    } else {
        $error = "Gagal mengedit peminjaman.";
    }
} else {
    $sql = "SELECT * FROM peminjaman WHERE id_peminjaman = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_peminjaman);
    $stmt->execute();
    $result = $stmt->get_result();
    $peminjaman = $result->fetch_assoc();
}

$sql = "SELECT * FROM buku";
$buku_result = $conn->query($sql);
?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4" style="max-width: 600px; width: 100%;">
        <h2 class="card-title">Edit Peminjaman</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="edit_peminjaman.php?id=<?php echo $id_peminjaman; ?>" method="post">
            <div class="mb-3">
                <label for="id_buku" class="form-label">Judul Buku</label>
                <select class="form-select" id="id_buku" name="id_buku" required>
                    <?php while ($row = $buku_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['id_buku']; ?>" <?php if ($row['id_buku'] == $peminjaman['id_buku']) echo 'selected'; ?>><?php echo $row['judul']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" value="<?php echo htmlspecialchars($peminjaman['nama_peminjam']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="<?php echo htmlspecialchars($peminjaman['tanggal_pinjam']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_jatuh_tempo" class="form-label">Tanggal Jatuh Tempo</label>
                <input type="date" class="form-control" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" value="<?php echo htmlspecialchars($peminjaman['tanggal_jatuh_tempo']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="dipinjam" <?php if ($peminjaman['status'] == 'dipinjam') echo 'selected'; ?>>Dipinjam</option>
                    <option value="dikembalikan" <?php if ($peminjaman['status'] == 'dikembalikan') echo 'selected'; ?>>Dikembalikan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Edit</button>
            <a href="peminjaman.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?php include('includes/footer.php'); ?>
