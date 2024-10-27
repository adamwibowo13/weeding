<?php
include 'db.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
    exit();
}

// Ambil ID data yang ingin diupdate
$id = $_GET['id']; // Pastikan Anda mengirimkan ID melalui URL

// Ambil data dari tabel
$query = "SELECT * FROM data_pasangan WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_pria = $_POST['nama_pria'];
    $ket_pria = $_POST['ket_pria'];
    $nama_wanita = $_POST['nama_wanita'];
    $ket_wanita = $_POST['ket_wanita'];
    $tanggal_pernikahan = $_POST['tanggal_pernikahan'];
    $surah = $_POST['surah'];
    $waktu_akad = $_POST['waktu_akad'];
    $waktu_resepsi = $_POST['waktu_resepsi'];
    $lokasi = $_POST['lokasi'];
    $alamat = $_POST['alamat'];
    $link_maps = $_POST['link_maps'];
    $rekening1 = $_POST['rekening1'];
    $norek1 = $_POST['norek1'];
    $rekening2 = $_POST['rekening2'];
    $norek2 = $_POST['norek2'];

    // Menampung data format file yang diizinkan
    $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

    // Mengupload foto pria
    $foto_pria = $data['foto_pria']; // Default ke foto lama
    if (!empty($_FILES['foto_pria']['name'])) {
        $tmp_name_pria = $_FILES['foto_pria']['tmp_name'];
        $type1_pria = explode('.', $_FILES['foto_pria']['name']);
        $type2_pria = strtolower(end($type1_pria));
        
        // Menentukan nama file baru
        $newname_pria = 'foto_pria_' . time() . '.' . $type2_pria;

        // Validasi format file
        if (!in_array($type2_pria, $tipe_diizinkan)) {
            echo '<script>alert("Format file tidak diizinkan untuk foto pria")</script>';
        } else {
            // Proses upload file
            if (move_uploaded_file($tmp_name_pria, 'img/foto-mem/' . $newname_pria)) {
                // Hapus foto lama jika ada
                if (!empty($foto_pria)) {
                    unlink('img/foto-mem/' . $foto_pria);
                }
                $foto_pria = $newname_pria; // Ganti foto_pria dengan nama baru
            }
        }
    } elseif (isset($_POST['hapus_foto_pria'])) {
        // Hapus foto jika checkbox dicentang
        if (!empty($foto_pria)) {
            unlink('img/foto-mem/' . $foto_pria);
            $foto_pria = null; // Set foto_pria menjadi null
        }
    }

    // Mengupload foto wanita
    $foto_wanita = $data['foto_wanita']; // Default ke foto lama
    if (!empty($_FILES['foto_wanita']['name'])) {
        $tmp_name_wanita = $_FILES['foto_wanita']['tmp_name'];
        $type1_wanita = explode('.', $_FILES['foto_wanita']['name']);
        $type2_wanita = strtolower(end($type1_wanita));

        // Menentukan nama file baru
        $newname_wanita = 'foto_wanita_' . time() . '.' . $type2_wanita;

        // Validasi format file
        if (!in_array($type2_wanita, $tipe_diizinkan)) {
            echo '<script>alert("Format file tidak diizinkan untuk foto wanita")</script>';
        } else {
            // Proses upload file
            if (move_uploaded_file($tmp_name_wanita, 'img/foto-mem/' . $newname_wanita)) {
                // Hapus foto lama jika ada
                if (!empty($foto_wanita)) {
                    unlink('img/foto-mem/' . $foto_wanita);
                }
                $foto_wanita = $newname_wanita; // Ganti foto_wanita dengan nama baru
            }
        }
    } elseif (isset($_POST['hapus_foto_wanita'])) {
        // Hapus foto jika checkbox dicentang
        if (!empty($foto_wanita)) {
            unlink('img/foto-mem/' . $foto_wanita);
            $foto_wanita = null; // Set foto_wanita menjadi null
        }
    }

    // Update data di database
    $update_query = "UPDATE data_pasangan SET 
        nama_pria = ?, 
        ket_pria = ?, 
        foto_pria = ?, 
        nama_wanita = ?, 
        ket_wanita = ?, 
        foto_wanita = ?, 
        tanggal_pernikahan = ?, 
        surah = ?, 
        waktu_akad = ?, 
        waktu_resepsi = ?, 
        lokasi = ?,
        alamat = ?,
        link_maps = ?,
        rekening1 = ?,
        norek1 = ?,
        rekening2 = ?,
        norek2 = ? 
    WHERE id = ?";

    // Persiapkan statement untuk update
    $update_stmt = $conn->prepare($update_query);
    if ($update_stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

// Bind parameter dengan benar
$update_stmt->bind_param("sssssssssssssssssi", 
    $nama_pria, 
    $ket_pria, 
    $foto_pria, 
    $nama_wanita, 
    $ket_wanita, 
    $foto_wanita, 
    $tanggal_pernikahan, 
    $surah, 
    $waktu_akad, 
    $waktu_resepsi, 
    $lokasi, 
    $alamat, 
    $link_maps, 
    $rekening1, 
    $norek1, 
    $rekening2, 
    $norek2,
    $id // ID harus di-bind terakhir
);


    // Eksekusi statement
    if ($update_stmt->execute()) {
        echo '<script>alert("Data berhasil diupdate!"); window.location="datamem.php?id=1";</script>';
    } else {
        echo "Error: " . $update_stmt->error; // Ubah untuk menggunakan error statement
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Aulia Reklame</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/logo-aulia.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="home.php" class="logo d-flex align-items-center">
                <span class="d-none d-lg-block">Aulia Reklame</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="users-profile.php" data-bs-toggle="dropdown">
                        <img src="assets/img/user.jpg" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">User</span>
                    </a><!-- End Profile Image Icon -->
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->
            </ul>
        </nav><!-- End Icons Navigation -->
    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link" href="home.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link" href="datamem.php?id=1">
                    <i class="bi bi-menu-button-wide"></i><span>Data Mempelai</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="story.php">
                    <i class="bi bi-journal-text"></i><span>Story</span>
                </a>
            </li><!-- End Forms Nav -->

            <li class="nav-item">
                <a class="nav-link" href="datatam.php">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Data Tamu</span>
                </a>
            </li><!-- End Tables Nav -->
            <!-- End Tables Nav -->
        </ul>
    </aside><!-- End Sidebar -->

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Data Mempelai</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                    <li class="breadcrumb-item active">Data Mempelai</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        

<section class="section">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Data Mempelai</h5>
                    <p>Silakan edit data.</p>

                    <!-- General Form Elements -->
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label for="nama_pria" class="col-sm-2 col-form-label">Nama Pengantin Pria</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_pria" value="<?php echo htmlspecialchars($data['nama_pria']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ket_pria" class="col-sm-2 col-form-label">Keterangan Pengantin Pria</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" style="height: 100px" name="ket_pria" required><?php echo htmlspecialchars($data['ket_pria']); ?></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="foto_pria" class="col-sm-2 col-form-label">Foto Mempelai Pria</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="foto_pria">
                                <?php if (!empty($data['foto_pria'])): ?>
                                    <img src="img/foto-mem/<?php echo htmlspecialchars($data['foto_pria']); ?>" alt="Foto Mempelai Pria" width="100" class="mt-2">
                                    <div>
                                        <input type="checkbox" name="hapus_foto_pria" id="hapus_foto_pria">
                                        <label for="hapus_foto_pria">Hapus foto</label>
                                    </div>
                                <?php else: ?>
                                    <p class="text-danger">Foto belum ditambah</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nama_wanita" class="col-sm-2 col-form-label">Nama Pengantin Wanita</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_wanita" value="<?php echo htmlspecialchars($data['nama_wanita']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ket_wanita" class="col-sm-2 col-form-label">Keterangan Pengantin Wanita</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" style="height: 100px" name="ket_wanita" required><?php echo htmlspecialchars($data['ket_pria']); ?></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="foto_wanita" class="col-sm-2 col-form-label">Foto Mempelai Wanita</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="foto_wanita">
                                <?php if (!empty($data['foto_wanita'])): ?>
                                    <img src="img/foto-mem/<?php echo htmlspecialchars($data['foto_wanita']); ?>" alt="Foto Mempelai Wanita" width="100" class="mt-2">
                                    <div>
                                        <input type="checkbox" name="hapus_foto_wanita" id="hapus_foto_wanita">
                                        <label for="hapus_foto_wanita">Hapus foto</label>
                                    </div>
                                <?php else: ?>
                                    <p class="text-danger">Foto belum ditambah</p>
                                <?php endif; ?>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="tanggal_pernikahan" class="col-sm-2 col-form-label">Tanggal Pernikahan</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="tanggal_pernikahan" value="<?php echo htmlspecialchars($data['tanggal_pernikahan']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="surah" class="col-sm-2 col-form-label">Surah Dari Kitab Agama</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" style="height: 100px" name="surah" required><?php echo htmlspecialchars($data['surah']); ?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="waktu_akad" class="col-sm-2 col-form-label">Waktu Akad</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="waktu_akad" value="<?php echo htmlspecialchars($data['waktu_akad']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="waktu_resepsi" class="col-sm-2 col-form-label">Waktu Resepsi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="waktu_resepsi" value="<?php echo htmlspecialchars($data['waktu_resepsi']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="lokasi" value="<?php echo htmlspecialchars($data['lokasi']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="alamat" value="<?php echo htmlspecialchars($data['alamat']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="link_maps" class="col-sm-2 col-form-label">link Google Maps</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="link_maps" value="<?php echo htmlspecialchars($data['link_maps']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="rekening1" class="col-sm-2 col-form-label"> Bank Rekening Ke-1</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="rekening1" value="<?php echo htmlspecialchars($data['rekening1']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="norek1" class="col-sm-2 col-form-label"> Nomor Rekening Ke-1</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="norek1" value="<?php echo htmlspecialchars($data['norek1']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="rekening2" class="col-sm-2 col-form-label">Bank Rekening Ke-2</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="rekening2" value="<?php echo htmlspecialchars($data['rekening2']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="norek2" class="col-sm-2 col-form-label"> Nomor Rekening Ke-2</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="norek2" value="<?php echo htmlspecialchars($data['norek2']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Update Data</button>
                            </div>
                        </div>
                    </form><!-- End General Form Elements -->
                </div>
            </div>
        </div>
    </div>
</section>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Prodigy Digital Solution</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed with ❤
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>
