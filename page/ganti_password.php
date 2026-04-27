<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Ganti Password</h1>
      </div>
    </div>
  </div>
</div>

<?php
include __DIR__ . "/../config/koneksi.php";

$username = $_SESSION['Username'];

if(isset($_POST['tambah'])){
  $pl = $_POST['pl'];
  $pb = $_POST['pb'];

  $cek = mysqli_query($koneksi,"SELECT * FROM users WHERE Username='$username' AND Password='$pl'");
  if(mysqli_num_rows($cek) > 0){
    $update = mysqli_query($koneksi,"UPDATE users SET Password='$pb' WHERE Username='$username'");
    if ($update){
      echo '<div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Password berhasil diganti, silakan login ulang.</h4></div>';
      echo '<meta http-equiv="refresh" content="1;url=logout.php">';
    } else {
      echo '<div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Gagal update password</h4></div>';
    }
  } else {
    echo '<div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
      <h5><i class="icon fas fa-ban"></i> Alert </h5>
      <h4>Password lama salah</h4></div>';
  }
}
?>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body p-2">
        <form method="POST" action="">
          <div class="form-group">
            <label for="pl">Password Lama</label>
            <input type="password" name="pl" id="pl" placeholder="Masukkan Password Lama" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="pb">Password Baru</label>
            <input type="password" name="pb" id="pb" placeholder="Masukkan Password Baru" class="form-control" required>
          </div>
          <div class="card-footer">
            <input type="submit" class="btn btn-primary" name="tambah" value="Ganti Password">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
