<?php include('includes/header.php'); ?>
<?php if (!isLoggedIn()) { header("Location: login.php"); exit; } ?>

<h2>Daftar Pengembalian</h2>
<a href="tambah_pengembalian.php" class="btn btn-primary mb-3">Tambah Pengembalian</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Peminjam</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Keterlambatan</th>
            <th>Kondisi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT pengembalian.*, peminjaman.nama_peminjam, buku.judul, peminjaman.tanggal_pinjam 
                FROM pengembalian 
                JOIN peminjaman ON pengembalian.id_peminjaman = peminjaman.id_peminjaman 
                JOIN buku ON peminjaman.id_buku = buku.id_buku";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $keterlambatan = ($row['keterlambatan'] > 0) ? $row['keterlambatan'] . " menit" : "Tepat waktu";
                echo "<tr>
                    <td>{$row['id_pengembalian']}</td>
                    <td>{$row['nama_peminjam']}</td>
                    <td>{$row['judul']}</td>
                    <td>{$row['tanggal_pinjam']}</td>
                    <td>{$row['tanggal_pengembalian']}</td>
                    <td>{$keterlambatan}</td>
                    <td>{$row['kondisi']}</td>
                    <td>
                        <a href='hapus_pengembalian.php?id={$row['id_pengembalian']}' class='btn btn-danger btn-sm'>Hapus</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Tidak ada pengembalian</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php include('includes/footer.php'); ?>
