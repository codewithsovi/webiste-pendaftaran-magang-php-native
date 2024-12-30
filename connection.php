<?php
$localhost = 'localhost';
$db_host = 'root';
$pass = '';
$db_name = 'mahasiswa_magang';

$koneksi = mysqli_connect($localhost, $db_host, $pass, $db_name);

// login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $cekuser = mysqli_query($koneksi, "SELECT * FROM users WHERE username ='$username' and password='$password'");
    $hitung = mysqli_num_rows($cekuser);

    if ($hitung > 0) {
        // kalau data ditemukan
        $ambildatarole = mysqli_fetch_array($cekuser);
        $role = $ambildatarole['role'];
        if ($role == 'admin') {
            $_SESSION['log'] == 'Logged';
            $_SESSION['role'] == 'admin';
            header('location:admin/dashboard.php');
        } elseif ($role == 'mahasiswa') {
            $_SESSION['log'] == 'Logged';
            $_SESSION['role'] == 'mahasiswa';
            header('location:mahasiswa');
        } elseif ($role == 'dosen_pembimbing') {
            $_SESSION['log'] == 'Logged';
            $_SESSION['role'] == 'dosen_pembimbing';
            header('location:dosen_pembimbing');
        } else {
            $_SESSION['log'] == 'Logged';
            $_SESSION['role'] == 'dosen_penguji';
            header('location:dosen_penguji');
        }
    } else {
        echo 'akun anda tidak ditemukan';
    }
}

// pembuatan Akun
if ($koneksi->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// menampilkan data
function tampil($query){
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows [] =$row;
    }
    return $rows;
}

// menambah akun 
function tambahAkun($data){
    global $koneksi;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $query = "INSERT INTO users (username, password, role, created_at, update_at)
            VALUES ('$username', '$password', '$role', NOW(), NOW())";


    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

?>
