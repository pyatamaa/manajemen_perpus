<?php include('includes/header.php'); ?>
<?php if (!isLoggedIn()) { header("Location: login.php"); exit; } ?>

<h2>Daftar Buku</h2>
<a href="tambah_buku.php" class="btn btn-primary mb-3">Tambah Buku</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Penerbit</th>
            <th>Tahun</th>
            <th>Genre</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM buku";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id_buku']}</td>
                    <td>{$row['judul']}</td>
                    <td>{$row['penulis']}</td>
                    <td>{$row['penerbit']}</td>
                    <td>{$row['tahun']}</td>
                    <td>{$row['genre']}</td>
                    <td>{$row['stok']}</td>
                    <td>
                        <a href='edit_buku.php?id={$row['id_buku']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='hapus_buku.php?id={$row['id_buku']}' class='btn btn-danger btn-sm'>Hapus</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Tidak ada buku</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php include('includes/footer.php'); ?>
