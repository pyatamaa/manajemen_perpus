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
                <h2>Daftar Pengembalian</h2>
            </div>
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
        </main>
    </div>
</div>

<?php include('includes/footer.php'); ?>
