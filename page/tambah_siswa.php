<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Data Siswa</h1>
      </div>
    </div>
  </div>
</div>

<?php
// proses simpan data siswa
if(isset($_POST['tambah'])){
  $nis      = $_POST['nis'];
  $nm_siswa = $_POST['nm_siswa'];
  $jenkel   = $_POST['jenkel'];
  $hp       = $_POST['hp'];
  $id_kelas = $_POST['id_kelas'];

  $insert = mysqli_query($koneksi,"INSERT INTO siswa (nis, nm_siswa, jenkel, hp, Id_kelas) 
                                   VALUES ('$nis','$nm_siswa','$jenkel','$hp','$id_kelas')");
  if ($insert){
    echo '<div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
      <h5><i class="icon fas fa-info"></i> Info </h5>
      <h4>Berhasil Disimpan</h4></div>';
    echo '<meta http-equiv="refresh" content="1;url=index.php?page=siswa">';
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
            <label for="nis">NIS</label>
            <input type="text" name="nis" id="nis" placeholder="Masukkan NIS" class="form-control" maxlength="10">
          </div>
          <div class="form-group">
            <label for="nm_siswa">Nama Siswa</label>
            <input type="text" name="nm_siswa" id="nm_siswa" placeholder="Nama Siswa" class="form-control">
          </div>
          <div class="form-group">
            <label for="jenkel">Jenis Kelamin</label>
            <select name="jenkel" id="jenkel" class="form-control">
              <option value="">-- Pilih Jenis Kelamin --</option>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
          <div class="form-group">
            <label for="hp">HP</label>
            <input type="text" name="hp" id="hp" placeholder="Nomor HP" class="form-control" maxlength="13">
          </div>
          <div class="form-group">
            <label for="id_kelas">Kelas</label>
            <select name="id_kelas" id="id_kelas" class="form-control">
              <option value="">-- Pilih Kelas --</option>
              <?php
                $query_kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
                while ($row_kelas = mysqli_fetch_array($query_kelas)) {
                  echo '<option value="'.$row_kelas['Id_kelas'].'">'.$row_kelas['Nm_kelas'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="card-footer">
            <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
