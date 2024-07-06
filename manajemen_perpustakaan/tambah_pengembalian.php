<?php include('includes/header.php'); ?>
<?php if (!isLoggedIn()) { header("Location: login.php"); exit; } ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_peminjaman = $_POST['id_peminjaman'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
    $kondisi = $_POST['kondisi'];

    // Hitung keterlambatan
    $sql = "SELECT tanggal_jatuh_tempo FROM peminjaman WHERE id_peminjaman = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_peminjaman);
    $stmt->execute();
    $result = $stmt->get_result();
    $peminjaman = $result->fetch_assoc();
    $tanggal_jatuh_tempo = $peminjaman['tanggal_jatuh_tempo'];

    $tanggal1 = new DateTime($tanggal_jatuh_tempo);
    $tanggal2 = new DateTime($tanggal_pengembalian);
    $interval = $tanggal1->diff($tanggal2);
    $keterlambatan = ($interval->invert == 1) ? 0 : ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

    $sql = "INSERT INTO pengembalian (id_peminjaman, tanggal_pengembalian, keterlambatan, kondisi) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isis", $id_peminjaman, $tanggal_pengembalian, $keterlambatan, $kondisi);
    if ($stmt->execute()) {
        // Update status peminjaman
        $sql = "UPDATE peminjaman SET status = 'dikembalikan' WHERE id_peminjaman = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_peminjaman);
        $stmt->execute();

        // Update stok buku
        $sql = "UPDATE buku SET stok = stok + 1 WHERE id_buku = (SELECT id_buku FROM peminjaman WHERE id_peminjaman = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_peminjaman);
        $stmt->execute();

        header("Location: pengembalian.php");
        exit;
    } else {
        $error = "Gagal menambahkan pengembalian.";
    }
}

$sql = "SELECT peminjaman.*, buku.judul 
        FROM peminjaman 
        JOIN buku ON peminjaman.id_buku = buku.id_buku 
        WHERE peminjaman.status = 'dipinjam'";
$peminjaman_result = $conn->query($sql);
?>

<h2>Tambah Pengembalian</h2>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<form action="tambah_pengembalian.php" method="post">
    <div class="mb-3">
        <label for="id_peminjaman" class="form-label">Judul Buku (Peminjaman)</label>
        <select class="form-select" id="id_peminjaman" name="id_peminjaman" required>
            <?php while ($row = $peminjaman_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id_peminjaman']; ?>"><?php echo $row['judul'] . " (Dipinjam oleh " . $row['nama_peminjam'] . ")"; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
        <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" required>
    </div>
    <div class="mb-3">
        <label for="kondisi" class="form-label">Kondisi Buku</label>
        <select class="form-select" id="kondisi" name="kondisi" required>
            <option value="baik">Baik</option>
            <option value="rusak">Rusak</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Tambah</button>
</form>

<?php include('includes/footer.php'); ?>
