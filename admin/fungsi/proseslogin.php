<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script type="text/javascript" src="../../lib/sweet.js"></script>
</head>
<body>

<?php
    // Include file koneksi.php
    include "koneksi.php";

    // Tangkap data dari form login
    $user = isset($_POST['username']) ? $_POST['username'] : '';
    $pass = isset($_POST['password']) ? $_POST['password'] : '';

    try {
        // Buat query menggunakan parameterized statement untuk mencegah SQL Injection
        $sql = $pdo->prepare("SELECT * FROM login WHERE username = :username AND password = :password");
        $sql->bindParam(':username', $user);
        $sql->bindParam(':password', $pass); // Sesuaikan format password di database (tanpa MD5 jika `123` plaintext)
        $sql->execute();

        // Cek apakah data ditemukan
        if ($sql->rowCount() > 0) {
            // Login berhasil
            $akses = $sql->fetch();
            session_start();
            $_SESSION['ceklog'] = $akses['username'];

            echo "<script>swal({
                type: 'success',
                title: 'Login Sukses!',
                showConfirmButton: false,
                backdrop: 'rgba(0,0,123,0.5)'
            });
            window.setTimeout(function(){
                window.location.replace('../beranda');
            }, 1500);</script>";
        } else {
            // Login gagal
            echo "<script>swal({
                type: 'error',
                title: 'Gagal!',
                text: 'Username atau Password salah.',
                showConfirmButton: false,
                backdrop: 'rgba(123,0,0,0.5)'
            });
            window.setTimeout(function(){
                window.location.replace('../');
            }, 1500);</script>";
        }
    } catch (PDOException $e) {
        // Tampilkan pesan error jika ada masalah koneksi atau query
        echo "Error: " . $e->getMessage();
    }
?>

</body>
</html>
