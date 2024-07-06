<?php include('includes/header.php'); ?>
<?php if (!isLoggedIn()) { header("Location: login.php"); exit; } ?>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dashboard.php">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="buku.php">
                            Data Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="peminjaman.php">
                            Data Peminjaman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pengembalian.php">
                            Data Pengembalian
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2>Dashboard</h2>

            <?php
            // Total buku
            $sql = "SELECT COUNT(*) as total_buku FROM buku";
            $result = $conn->query($sql);
            $total_buku = $result->fetch_assoc()['total_buku'];

            // Total peminjaman
            $sql = "SELECT COUNT(*) as total_peminjaman FROM peminjaman WHERE status = 'dipinjam'";
            $result = $conn->query($sql);
            $total_peminjaman = $result->fetch_assoc()['total_peminjaman'];

            // Total pengembalian
            $sql = "SELECT COUNT(*) as total_pengembalian FROM pengembalian";
            $result = $conn->query($sql);
            $total_pengembalian = $result->fetch_assoc()['total_pengembalian'];

            // Buku yang dipinjam
            $sql = "SELECT SUM(stok) as total_stok FROM buku";
            $result = $conn->query($sql);
            $total_stok = $result->fetch_assoc()['total_stok'];
            $sql = "SELECT COUNT(*) as buku_dipinjam FROM peminjaman WHERE status = 'dipinjam'";
            $result = $conn->query($sql);
            $buku_dipinjam = $result->fetch_assoc()['buku_dipinjam'];
            $buku_dipinjam_persen = ($buku_dipinjam / $total_stok) * 100;
            ?>

            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Buku</h5>
                            <p class="card-text"><?php echo $total_buku; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Buku Dipinjam</h5>
                            <p class="card-text"><?php echo $total_peminjaman; ?> (<?php echo round($buku_dipinjam_persen, 2); ?>%)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Pengembalian</h5>
                            <p class="card-text"><?php echo $total_pengembalian; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include('includes/footer.php'); ?>
