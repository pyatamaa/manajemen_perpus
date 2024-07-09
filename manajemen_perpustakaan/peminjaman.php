<?php
session_start();
include('includes/config.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}
?>

<div class="container-fluid" style="margin-top: 56px;">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Daftar Peminjaman</h2>
            </div>
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
        </main>
    </div>
</div>

<?php include('includes/footer.php'); ?>
