<?php
  include "config/koneksi.php";
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Admin</b>LTE</a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="login.php" method="post">
        <div class="input-group mb-3">
          <input type="text" name="Username" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="Password" class="form-control" id="Password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
            <div class="input-group-text" onclick="togglePassword()" style="cursor:pointer;">
              <span id="toggleIcon" class="fas fa-eye"></span>
            </div>
          </div>
        </div>
        <div class="col-15">
          <button type="submit" name="login" value="login" class="btn btn-primary btn-block">Login</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script>
function togglePassword() {
  const passwordInput = document.getElementById("Password");
  const toggleIcon = document.getElementById("toggleIcon");
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    toggleIcon.classList.replace("fa-eye", "fa-eye-slash");
  } else {
    passwordInput.type = "password";
    toggleIcon.classList.replace("fa-eye-slash", "fa-eye");
  }
}
</script>
</body>
</html>

<?php
if (isset($_POST['login'])) {
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

    if (empty($Username) || empty($Password)) {
        echo "<script>alert('Username dan Password tidak boleh kosong!');</script>";
    } else {
        $userquery = mysqli_fetch_array(
            mysqli_query($koneksi, "SELECT * FROM users WHERE Username = '$Username' AND Password = '$Password'")
        );

        if ($userquery) {
            $role = $userquery['Role'];
            $_SESSION['Role']     = $role;
            $_SESSION['Username'] = $Username;

            // Simpan data tambahan ke session sesuai role
            if ($role == 'guru') {
                // Cari kd_guru berdasarkan nm_guru yang mirip dengan Username
                $sqlGuru = "SELECT kd_guru, nm_guru FROM guru WHERE nm_guru LIKE '%$Username%' LIMIT 1";
                $resGuru = mysqli_fetch_array(mysqli_query($koneksi, $sqlGuru));
                if ($resGuru) {
                    $_SESSION['kd_guru'] = $resGuru['kd_guru'];
                    $_SESSION['nm_guru'] = $resGuru['nm_guru'];
                }
            }

            if ($role == 'siswa') {
                // Cari nis dan id_kelas berdasarkan nm_siswa yang mirip dengan Username
                $sqlSiswa = "SELECT nis, nm_siswa, id_kelas FROM siswa WHERE nm_siswa LIKE '%$Username%' LIMIT 1";
                $resSiswa = mysqli_fetch_array(mysqli_query($koneksi, $sqlSiswa));
                if ($resSiswa) {
                    $_SESSION['nis']      = $resSiswa['nis'];
                    $_SESSION['nm_siswa'] = $resSiswa['nm_siswa'];
                    $_SESSION['id_kelas'] = $resSiswa['id_kelas'];
                }
            }

            // Redirect jika password masih default
            if ($userquery['Password'] == '1234' && ($role == 'guru' || $role == 'siswa')) {
                header("Location: index.php?page=ganti_password");
                exit;
            } else {
                header("Location: index.php");
                exit;
            }
        } else {
            echo "<script>alert('Username atau Password salah!');</script>";
        }
    }
}
?>