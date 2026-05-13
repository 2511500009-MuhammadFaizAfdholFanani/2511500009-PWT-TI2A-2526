<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Tambah Jadwal</h1>
      </div>
    </div>
  </div>
</div>

<?php
$carikode = mysqli_query($koneksi,"SELECT max(Id_jadwal) FROM jadwal") or die (mysqli_error($koneksi));
$datakode = mysqli_fetch_array($carikode);
if($datakode[0]) {
  $hasilkode = (int)$datakode[0] + 1;
} else {
  $hasilkode = 1;
}
$_SESSION["KODE"] = $hasilkode;

if(isset($_POST['tambah'])){
  $id_jadwal  = $_POST['id_jadwal'];
  $id_kelas   = $_POST['id_kelas'];
  $thn_ajaran = $_POST['thn_ajaran'];
  $semester   = $_POST['semester'];

  $insert = mysqli_query($koneksi,"INSERT INTO jadwal (Id_jadwal, Id_kelas, thn_ajaran, semester) 
                                   VALUES ('$id_jadwal','$id_kelas','$thn_ajaran','$semester')");
  if ($insert){
    echo '<div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
      <h5><i class="icon fas fa-info"></i> Info </h5>
      <h4>Berhasil Disimpan</h4></div>';
    echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal">';
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
            <label for="id_jadwal">ID Jadwal</label>
            <input type="number" name="id_jadwal" id="id_jadwal" class="form-control" value="<?= $hasilkode; ?>" readonly>
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
          <div class="form-group">
            <label for="thn_ajaran">Tahun Ajaran</label>
            <input type="text" name="thn_ajaran" id="thn_ajaran" placeholder="2024/2025" class="form-control" maxlength="10">
          </div>
          <div class="form-group">
            <label for="semester">Semester</label>
            <select name="semester" id="semester" class="form-control">
              <option value="">-- Pilih Semester --</option>
              <option value="ganjil">Ganjil</option>
              <option value="genap">Genap</option>
            </select>
          </div>
          <div class="card-footer">
            <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php?page=jadwal'">Kembali</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>