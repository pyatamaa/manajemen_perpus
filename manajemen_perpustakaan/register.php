<?php
include('includes/header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = $_POST['nama'];

    // Cek apakah username sudah ada
    $sql = "SELECT id_pustakawan FROM pustakawan WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Username sudah terdaftar.";
    } else {
        $sql = "INSERT INTO pustakawan (username, password, nama) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $nama);
        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Gagal mendaftarkan akun.";
        }
    }
}
?>

<h2>Register</h2>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<form action="register.php" method="post">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
</form>

<?php include('includes/footer.php'); ?>