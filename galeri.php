<?php
include 'db.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
    exit();
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
                <a class="nav-link" href="galeri.php">
                    <i class="bi bi-camera-fill"></i><span>galeri</span>
                </a>
            </li>

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
            <h1>Galery</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                    <li class="breadcrumb-item active">Galeri</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        

        <section class="section">
        <div class="row">
            <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Galeri</h5>
                <button type="button" class="btn btn-primary" onclick="window.location.href='addgaleri.php';">
                    <i class="bx bxs-duplicate"></i> Tambahkan Foto
                </button>

                <p>Data berikut adalah Galeri.</p>

                <!-- Table with stripped rows -->
                <table class="table datatable">
                <thead>
                    <tr>
                    <th>Foto</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    // Query untuk mengambil data dari tabel list_int
                    $sql = "SELECT id, foto FROM galeri";
                    $result = $conn->query($sql);

                    // Cek apakah ada hasil
                    if ($result->num_rows > 0) {
                        // Tampilkan data dalam tabel
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>";
                            // Use a ternary operator to handle image display
                            if (!empty($row['foto'])) {
                                echo "<img src='img/galeri/" . htmlspecialchars($row['foto']) . "' alt='Foto Galeri' width='100' class='img-thumbnail'>";
                            } else {
                                echo "<p class='text-danger'>Foto tidak tersedia</p>";
                            }
                    
                            echo "</td>
                                    <td>
                                        <button type='button' class='btn btn-danger' onclick=\"window.location.href='hapusgaleri.php?id={$row['id']}';\">
                                            <i class='bi bi-exclamation-octagon'></i> Hapus
                                        </button>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Tidak ada data ditemukan</td></tr>";
                    }
                    // Tutup koneksi
                    $conn->close();
                    ?>
                </tbody>
                </table>
                <!-- End Table with stripped rows -->

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
