<?php
include "koneksi.php";


if (isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit;
}

$pesan = "";

if (isset($_POST['masuk'])) {
  $email = mysqli_real_escape_string($koneksi, strtolower(trim($_POST['email'])));
  $password = $_POST['password'];

  $hasil = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
  $user = mysqli_fetch_assoc($hasil);

  

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['email'] = $user['email'];
    header("Location: index.php");
    exit;
  } else {
    $pesan = "Email atau kata sandi tidak cocok.";
  }
}

if (isset($_POST['demo'])) {
  $emailDemo = "demo@tugasin.test";

  $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$emailDemo'");

  
  if (mysqli_num_rows($cek) == 0) {
    $hash = password_hash("demo1234", PASSWORD_DEFAULT);

    mysqli_query($koneksi, "INSERT INTO users (nama, email, password) VALUES ('Mahasiswa Demo', '$emailDemo', '$hash')");

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$emailDemo'");
  }

  $user = mysqli_fetch_assoc($cek);

  $_SESSION['user_id'] = $user['id'];
  $_SESSION['nama'] = $user['nama'];
  $_SESSION['email'] = $user['email'];
  header("Location: index.php");
  exit;
}

?>
<!DOCTYPE html>
<html lang="id" data-tema="light" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tugasin - Pengelola Tugas Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>

<div class="layar-auth">

  <aside class="panel-sapa">
    <a class="brand" href="login.php">Tugas<span>in.</span></a>

    <div>
      <h1>Semua tugas kuliah,<br>lebih teratur.</h1>
      <p>Catat deadline, atur prioritas, dan selesaikan tugas satu per satu tanpa perlu bingung.</p>

      <div class="sapa-mini">
        <strong>Tetap produktif!</strong>
        <p class="mb-0 mt-2">Satu tempat untuk semua tugas yang perlu kamu kerjakan.</p>
      </div>
    </div>

    <small>Tugasin - Website pengelola tugas mahasiswa</small>
  </aside>

  <main class="form-auth">


    <section class="kartu">
      <h2 class="fw-bold mb-2">Selamat datang!</h2>
      <p class="text-secondary mb-4">Masuk untuk melihat daftar tugasmu.</p>

      <?php if ($pesan != "") { ?>
        <div class="pesan"><?php echo $pesan; ?></div>
      <?php } ?>

      <form method="post">
        <label class="form-label fw-semibold">Email</label>
        <input class="form-control mb-3" type="email" name="email" placeholder="nama@email.com" required>

        <label class="form-label fw-semibold">Kata sandi</label>
        <input class="form-control mb-4" type="password" name="password" placeholder="Masukkan kata sandi" required>

        <button class="btn btn-hijau w-100 py-3" type="submit" name="masuk">Masuk</button>
      </form>

      <div class="text-center mt-3">
        Belum punya akun? <a href="daftar.php">Daftar di sini</a>
      </div>
            <hr>

      <form method="post">
        <button class="btn btn-outline-success w-100" type="submit" name="demo">Masuk akun demo</button>
      </form>

      <p class="teks-kecil mt-3 mb-0">
        Akun demo hanya untuk mencoba. Jangan gunakan kata sandi asli.
      </p>
    </section>

  </main>
</div>

<script src="js/script.js"></script>
</body>
</html>

