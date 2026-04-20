<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Tambah Kelas</h1>
      </div>
    </div>
  </div>
</div>

<?php
// proses simpan data kelas
if(isset($_POST['tambah'])){
  $id_kelas = $_POST['id_kelas'];
  $nm_kelas = $_POST['nm_kelas'];

  $insert = mysqli_query($koneksi,"INSERT INTO kelas (Id_kelas, Nm_kelas) VALUES ('$id_kelas','$nm_kelas')");
  if ($insert){
    echo '<div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
      <h5><i class="icon fas fa-info"></i> Info </h5>
      <h4>Berhasil Disimpan</h4></div>';
    echo '<meta http-equiv="refresh" content="1;url=index.php?page=kelas">';
  } else {
    echo '<div class="alert alert-warning alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
      <h5><i class="icon fas fa-info"></i> Info </h5>
      <h4>Gagal Disimpan</h4></div>';
  }
}
?>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body p-2">
        <form method="POST" action="">
          <div class="form-group">
            <label for="id_kelas">ID Kelas</label>
            <input type="number" name="id_kelas" id="id_kelas" placeholder="Masukkan ID Kelas" class="form-control">
          </div>
          <div class="form-group">
            <label for="nm_kelas">Nama Kelas</label>
            <input type="text" name="nm_kelas" id="nm_kelas" placeholder="Nama Kelas" class="form-control" maxlength="30">
          </div>
          <div class="card-footer">
            <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>