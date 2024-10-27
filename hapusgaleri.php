<?php
include 'db.php'; // Include database connection
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
    exit();
}

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data dari tabel untuk mendapatkan nama file foto
$query = "SELECT foto FROM galeri WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $foto = $row['foto'];

    // Hapus data dari tabel
    $delete_query = "DELETE FROM galeri WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $id);

    if ($delete_stmt->execute()) {
        // Hapus foto dari direktori jika ada
        if (!empty($foto)) {
            $file_path = 'img/galeri/' . $foto;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        echo '<script>alert("Data berhasil dihapus!"); window.location="galeri.php";</script>';
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo '<script>alert("Data tidak ditemukan!"); window.location="galeri.php";</script>';
}

$stmt->close();
$conn->close();
?>
