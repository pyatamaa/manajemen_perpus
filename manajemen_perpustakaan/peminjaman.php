<?php include('includes/header.php'); ?>
<?php if (!isLoggedIn()) { header("Location: login.php"); exit; } ?>

<h2>Daftar Peminjaman</h2>
<a href="tambah_peminjaman.php" class="btn btn-primary mb-3">Tambah Peminjaman</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Peminjam</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Jatuh Tempo</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT peminjaman.*, buku.judul FROM peminjaman JOIN buku ON peminjaman.id_buku = buku.id_buku";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id_peminjaman']}</td>
                    <td>{$row['nama_peminjam']}</td>
                    <td>{$row['judul']}</td>
                    <td>{$row['tanggal_pinjam']}</td>
                    <td>{$row['tanggal_jatuh_tempo']}</td>
                    <td>{$row['status']}</td>
                    <td>
                        <a href='edit_peminjaman.php?id={$row['id_peminjaman']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='hapus_peminjaman.php?id={$row['id_peminjaman']}' class='btn btn-danger btn-sm'>Hapus</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Tidak ada peminjaman</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php include('includes/footer.php'); ?>
