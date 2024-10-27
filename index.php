<?php 
// Include file koneksi
include 'db.php';

// Ambil ID tamu dari parameter GET
$id_tamu = $_GET['id'];

// Ambil data tamu berdasarkan ID
$sql_tamu = "SELECT nama, keterangan FROM tamu WHERE id = ?";
$stmt_tamu = $conn->prepare($sql_tamu);
$stmt_tamu->bind_param("i", $id_tamu);
$stmt_tamu->execute();
$result_tamu = $stmt_tamu->get_result();

if ($result_tamu->num_rows > 0) {
    $tamu = $result_tamu->fetch_assoc();
    $nama_tamu = $tamu['nama'];
    $keterangan_tamu = $tamu['keterangan'];
  } else {
    echo "Tamu tidak ditemukan.";
    exit;
}

// Ambil data pasangan (asumsi hanya ada satu data)
$sql_pasangan = "SELECT nama_pria, ket_pria, foto_pria, nama_wanita, ket_wanita, foto_wanita, tanggal_pernikahan, lokasi, waktu_akad, waktu_resepsi, alamat, link_maps, rekening1, norek1, rekening2, norek2 FROM data_pasangan LIMIT 1";
$result_pasangan = $conn->query($sql_pasangan);

if ($result_pasangan->num_rows > 0) {
    $pasangan = $result_pasangan->fetch_assoc();
    $nama_pria = $pasangan['nama_pria'];
    $ket_pria = $pasangan ['ket_pria'];
    $foto_pria = $pasangan['foto_pria'];
    $nama_wanita = $pasangan['nama_wanita'];
    $ket_wanita = $pasangan ['ket_wanita'];
    $foto_wanita = $pasangan['foto_wanita'];
    $tanggal_pernikahan = $pasangan['tanggal_pernikahan'];
    $tempat_pernikahan = $pasangan['lokasi'];
    $alamat = $pasangan['alamat'];
    $link_maps = $pasangan['link_maps'];
    $waktu_akad = $pasangan['waktu_akad'];
    $waktu_resepsi = $pasangan['waktu_resepsi'];
    $rekening1 = $pasangan['rekening1'];
    $norek1 = $pasangan['norek1'];
    $rekening2 = $pasangan['rekening2'];
    $norek2 = $pasangan['norek2'];

    // Format tanggal untuk ditampilkan
    $date_parts = date_parse($tanggal_pernikahan);
    $formatted_date = sprintf("%02d %s %d", $date_parts['day'], strftime("%B", mktime(0, 0, 0, $date_parts['month'], 10)), $date_parts['year']);


    // Format tanggal untuk JavaScript
    $date_parts = date_parse($tanggal_pernikahan);
    $year = $date_parts['year'];
    $month = $date_parts['month'];
    $day = $date_parts['day'];
} else {
    echo "Data pasangan tidak ditemukan.";
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Wedding Invitation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Sacramento&family=Work+Sans:wght@100;300;400;600;700&display=swap"
    rel="stylesheet">

  <!-- simplyCountdown -->
  <link rel="stylesheet" href="countdown/simplyCountdown.theme.default.css" />
  <script src="countdown/simplyCountdown.min.js"></script>
  <script src="/effect.js"></script>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/cssbaru.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

<section id="hero" class="hero w-100 h-100 p-3 mx-auto text-center d-flex justify-content-center align-items-center text-white">

<main>
      <h4>Kepada Yth Bapak/Ibu</h4>
      <p><?php echo htmlspecialchars($nama_tamu); ?></p>
      <p><?php echo htmlspecialchars($keterangan_tamu); ?></p>
      <h1><?php echo htmlspecialchars($nama_pria); ?> & <?php echo htmlspecialchars($nama_wanita); ?></h1>
      <p>Akan melangsungkan resepsi pernikahan dalam:</p>
      <div id="countdown" class="simply-countdown"></div>
      <a href="#home" class="btn btn-lg mt-4" style="color: white;" onClick="enableScroll()">Lihat Undangan</a>
    </main>
</section>

<script>
  // Memanggil fungsi simplyCountdown dengan tanggal pernikahan
  simplyCountdown('#countdown', {
    year: <?php echo $year; ?>,
    month: <?php echo $month; ?>,
    day: <?php echo $day; ?>,
    hours: 0,
    minutes: 0,
    seconds: 0,
    onEnd: function() {
      console.log('Countdown selesai!');
    }
  });
</script>

  <nav class="navbar navbar-expand-md bg-transparent sticky-top mynavbar">
    <div class="container">
      <a class="navbar-brand" href="#"></a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <section id="home" class="home">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 text-center">
          <h2>Acara Pernikahan</h2>
          <h3>Dengan tanpa mengurangi rasa hormat</h3>
          <h3>kami bermaksud untuk mengudang bapak/ibu, saudara/i, utuk hadir ke acara pernikahan kami</h3>
        </div>
      </div>

      <div class="row couple">
        <div class="col-lg-6">
          <div class="row">
            <div class="col-8 text-end">
              <h3><?php echo htmlspecialchars($nama_pria); ?></h3>
              <p><?php echo htmlspecialchars($ket_pria); ?></p>
            </div>
            <div class="col-4">
                <img src="img/foto-mem/<?php echo htmlspecialchars($foto_pria); ?>" alt="<?php echo htmlspecialchars($nama_pria); ?>" class="img-responsive rounded-circle">
            </div>
          </div>
        </div>

        <span class="heart"><i class="bi bi-heart-fill"></i></span>

        <div class="col-lg-6">
          <div class="row">
          <div class="col-4">
              <img src="img/foto-mem/<?php echo htmlspecialchars($foto_wanita); ?>" alt="<?php echo htmlspecialchars($nama_pria); ?>" class="img-responsive rounded-circle">
          </div>
            <div class="col-8">
              <h3><?php echo htmlspecialchars($nama_wanita); ?></h3>
              <p><?php echo htmlspecialchars($ket_wanita); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section id="info" class="info">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-10 text-center">
          <h2>Informasi Acara</h2>
          <p class="alamat">Alamat: <?php echo htmlspecialchars($alamat); ?></p>
          <a href="<?php echo htmlspecialchars($link_maps); ?>" target="_blank" class="btn btn-light btn-sm my-3">Klik untuk
            membuka peta</a>
          <p class="description">Diharapkan untuk tidak salah alamat dan tanggal. Manakala tiba di tujuan namun tidak
            ada tanda-tanda sedang dilangsungkan pernikahan, boleh jadi Anda salah jadwal, atau salah tempat.</p>
        </div>
      </div>

      <div class="row justify-content-center mt-4">
        <div class="col-md-5 col-10">
          <div class="card text-center text-bg-light mb-5">
            <div class="card-header">Akad Nikah</div>
            <div class="card-body">
              <div class="row justify-content-center">
                <div class="col-md-6">
                  <i class="bi bi-clock d-block"></i>
                  <span><?php echo htmlspecialchars($waktu_akad); ?>  - Selesai</span>
                </div>
                <div class="col-md-6">
                  <i class="bi bi-calendar3 d-block"></i>
                  <span><?php echo htmlspecialchars($formatted_date); ?></span>
                </div>
              </div>
            </div>
            <div class="card-footer">
              Saat acara akad diharapkan untuk kondusif menjaga kekhidmatan dan kekhusyuan seluruh prosesi.
            </div>
          </div>
        </div>
        <div class="col-md-5 col-10">
          <div class="card text-center text-bg-light">
            <div class="card-header">Resepsi</div>
            <div class="card-body">
              <div class="row justify-content-center">
                <div class="col-md-6">
                  <i class="bi bi-clock d-block"></i>
                  <span><?php echo htmlspecialchars($waktu_resepsi); ?> - Selesai</span>
                </div>
                <div class="col-md-6">
                  <i class="bi bi-calendar3 d-block"></i>
                  <span><?php echo htmlspecialchars($formatted_date); ?></span>
                </div>
              </div>
            </div>
            <div class="card-footer">
              Saat acara akad diharapkan untuk kondusif menjaga kekhidmatan dan kekhusyuan seluruh prosesi.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="story" class="story">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-10 text-center">
                <span>Bagaimana Cinta Kami Bersemi</span>
                <h2>Cerita Kami</h2>
                <p>Setiap langkah yang kami ambil bersama adalah bagian dari kisah indah yang tak terlupakan.</p>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <ul class="timeline">
                    <?php
                    include 'db.php';

                    // Query untuk mengambil data cerita dari database
                    $query = "SELECT * FROM story ORDER BY tanggal ASC";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $formattedDate = date("d F Y", strtotime($row['tanggal']));
                            // Menampilkan setiap cerita dalam format timeline
                            echo "<li>
                                    <div class='timeline-image' style='background-image: url(img/foto-story/" . htmlspecialchars($row['foto']) . ");'></div>
                                    <div class='timeline-panel'>
                                        <div class='timeline-heading'>
                                            <h3>" . htmlspecialchars($row['title']) . "</h3>
                                            <span>{$formattedDate}</span>
                                        </div>
                                        <div class='timeline-body'>
                                            <p>" . htmlspecialchars($row['keterangan']) . "</p>
                                        </div>
                                    </div>
                                  </li>";
                        }
                    } else {
                        echo "<li><div class='timeline-panel'><p>Tidak ada cerita ditemukan.</p></div></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>
  <section id="gallery" class="gallery">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-10 text-center">
          <span>Memori Kisah Kami</span>
          <h2>Galeri Foto</h2>
          <p>Selamat datang di galeri kami, setiap foto menyimpan kenangan indah dari perjalanan cinta kami.</p>
        </div>
      </div>

      <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 justify-content-center">
    <?php
    include 'db.php'; // Pastikan untuk menyertakan koneksi database

    // Query untuk mengambil data foto dari tabel galeri
    $query = "SELECT foto FROM galeri";
    $result = $conn->query($query);

    // Cek jika ada data
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $foto = htmlspecialchars($row['foto']);
            echo "
            <div class='col mt-3'>
                <a href='img/galeri/$foto' data-toggle='lightbox' data-caption='Galeri Foto' data-gallery='mygallery'>
                    <img src='img/galeri/$foto' alt='Galeri Foto' class='img-fluid w-100 rounded'>
                </a>
            </div>";
        }
    } else {
        echo "<p>Tidak ada foto di galeri.</p>";
    }
    ?>
</div>
</section>

<section id="rsvp" class="rsvp">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-10 text-center">
                <h2>Konfirmasi Kehadiran</h2>
                <p>Isi form di bawah ini untuk melakukan konfirmasi kehadiran.</p>
            </div>
        </div>

        <form class="row row-cols-md-auto g-3 align-items-center justify-content-center" method="POST" action="" id="my-form">
            <div class="col-12">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($nama_tamu); ?>" readonly>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label for="komentar" class="form-label">Komentar</label>
                    <textarea class="form-control" id="komentar" name="komentar" rows="3" required></textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label for="status" class="form-label">Konfirmasi Kehadiran</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="" disabled selected>Pilih salah satu</option>
                        <option value="Hadir">Hadir</option>
                        <option value="Tidak Hadir">Tidak Hadir</option>
                    </select>
                </div>
            </div>
            <div class="col-12" style="margin-top: 35px;">
                <button class="btn btn-primary">Kirim</button>
            </div>
        </form>

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <h3>Seluruh Komentar</h3>
                <div class="list-group">
                    <?php
                    include 'db.php'; // Pastikan untuk menyertakan koneksi database

                    // Menangani penyimpanan komentar
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $nama = htmlspecialchars($_POST['nama']);
                        $konfirmasi = htmlspecialchars($_POST['status']); // Ambil status kehadiran dari form
                        $komentar = htmlspecialchars($_POST['komentar']);

                        // Query untuk menyimpan data ke tabel komentar
                        $insert_query = "INSERT INTO komentar (nama, konfirmasi, komentar) VALUES (?, ?, ?)";
                        $insert_stmt = $conn->prepare($insert_query);
                        
                        if ($insert_stmt) {
                            $insert_stmt->bind_param("sss", $nama, $konfirmasi, $komentar);

                            if ($insert_stmt->execute()) {
                                echo "<p class='text-success'>Komentar berhasil disimpan!</p>";
                                echo "<script>setTimeout(function(){ window.location.reload(); }, 2000);</script>"; // Refresh setelah 2 detik
                            } else {
                                echo "<p class='text-danger'>Error: " . htmlspecialchars($conn->error) . "</p>";
                            }

                            $insert_stmt->close();
                        } else {
                            echo "<p class='text-danger'>Error: " . htmlspecialchars($conn->error) . "</p>";
                        }
                    }

                    // Query untuk mengambil semua komentar
                    $query = "SELECT nama, konfirmasi, komentar FROM komentar ORDER BY id DESC";
                    $result = $conn->query($query);

                    // Cek jika query berhasil
                    if ($result) {
                        // Cek jika ada komentar
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='list-group-item'>
                                          <strong style='font-size: 1.5em; color: black;'>" . htmlspecialchars($row['nama']) . "</strong>
                                          <h6 style='font-size: 0.9em; color: gray;'>" . htmlspecialchars($row['konfirmasi']) . "</h6>                  
                                          <p style='color: black; font-size: 1.2em;'>" . htmlspecialchars($row['komentar']) . "</p>
                                      </div>";
                                      echo "<br>";
                            }
                        } else {
                            echo "<p>Tidak ada komentar.</p>";
                        }
                    } else {
                        echo "<p>Error: " . htmlspecialchars($conn->error) . "</p>";
                    }

                    // Tutup koneksi
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>



<section id="gifts" class="gifts">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-10 text-center">
          <span>Ungkapan Tanda Kasih</span>
          <h2>Kirim Hadiah</h2>
          <p>Anda Dapat mengirim Hadiah ke Alamat Berikut : <?php echo htmlspecialchars($alamat); ?>
          </p>
        </div>
      </div>

      <div class="row justify-content-center text-center">
      <div class="col-md-6">
          <ul class="list-group">
              <li class="list-group-item">
                  <div class="fw-bold"><?php echo htmlspecialchars($rekening1); ?></div>
                  <?php echo htmlspecialchars($norek1); ?>
              </li> <br> <br>
              <li class="list-group-item">
                  <div class="fw-bold"><?php echo htmlspecialchars($rekening2); ?></div>
                  <?php echo htmlspecialchars($norek2); ?>
              </li>
          </ul>
      </div>
  </div>

    </div>
  </section>

  <footer>
    <div class="container">
      <div class="row">
        <div class="col text-center">
          <small class="block">&copy; 2024 Prodigy Digital Solution. All Rights Reserved.</small>

          <ul class="mt-3">
            <li><a href="#"><i class="bi bi-instagram"></i></a></li>
            <li><a href="#"><i class="bi bi-youtube"></i></a></li>
            <li><a href="#"><i class="bi bi-twitter"></i></a></li>
            <li><a href="#"><i class="bi bi-facebook"></i></a></li>
            <li><a href="#"><i class="bi bi-tiktok"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <div id="audio-container">
    <audio id="song" autoplay loop>
      <source src="audio/Bruno Mars - Marry You.mp3" type="audio/mp3">
    </audio>

    <div class="audio-icon-wrapper" style="display: none;">
      <i class="bi bi-disc"></i>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>


  <script>
    const stickyTop = document.querySelector('.sticky-top');
    const offcanvas = document.querySelector('.offcanvas');

    offcanvas.addEventListener('show.bs.offcanvas', function () {
      stickyTop.style.overflow = 'visible';
    });

    offcanvas.addEventListener('hidden.bs.offcanvas', function () {
      stickyTop.style.overflow = 'hidden';
    });

  </script>

  <script>
    const rootElement = document.querySelector(":root");
    const audioIconWrapper = document.querySelector('.audio-icon-wrapper');
    const audioIcon = document.querySelector('.audio-icon-wrapper i');
    const song = document.querySelector('#song');
    let isPlaying = false;

    function disableScroll() {
      scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

      window.onscroll = function () {
        window.scrollTo(scrollTop, scrollLeft);
      }

      rootElement.style.scrollBehavior = 'auto';
    }

    function enableScroll() {
      window.onscroll = function () { }
      rootElement.style.scrollBehavior = 'smooth';
      // localStorage.setItem('opened', 'true');
      playAudio();
    }

    function playAudio() {
      song.volume = 0.1;
      audioIconWrapper.style.display = 'flex';
      song.play();
      isPlaying = true;
    }

    audioIconWrapper.onclick = function () {
      if (isPlaying) {
        song.pause();
        audioIcon.classList.remove('bi-disc');
        audioIcon.classList.add('bi-pause-circle');
      } else {
        song.play();
        audioIcon.classList.add('bi-disc');
        audioIcon.classList.remove('bi-pause-circle');
      }

      isPlaying = !isPlaying;
    }

    // if (!localStorage.getItem('opened')) {
    //   disableScroll();
    // }
    disableScroll();
  </script>
  <script>
    window.addEventListener("load", function () {
      const form = document.getElementById('my-form');
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        const data = new FormData(form);
        const action = e.target.action;
        fetch(action, {
          method: 'POST',
          body: data,
        })
          .then(() => {
            alert("Konfirmasi kehadiran berhasil terkirim!");
          })
      });
    });

  </script>
  <script>
    const urlParams = new URLSearchParams(window.location.search);
    const nama = urlParams.get('n') || '';
    const pronoun = urlParams.get('p') || 'Bapak/Ibu/Saudara/i';
    const namaContainer = document.querySelector('.hero h4 span');
    namaContainer.innerText = `${pronoun} ${nama},`.replace(/ ,$/, ',');

    document.querySelector('#nama').value = nama;
  </script>
</body>

</html>