<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Data Ekstrakurikuler</h1>
      </div>
    </div>
  </div>
</div>

<?php
if(isset($_POST['tambah'])){
  $id_ekstra = $_POST['id_ekstra009'];
  $nm_ekstra = $_POST['nama_ekstra009'];
  $keterangan = $_POST['ket009'];
  $semester = $_POST['semester009'];
  $tahun_ajaran = $_POST['thn_ajaran009'];
  
  $insert = mysqli_query($koneksi,"INSERT INTO ekstra_2511500009 
    (id_ekstra009, nama_ekstra009, ket009, semester009, thn_ajaran009) 
    VALUES ('$id_ekstra','$nm_ekstra','$keterangan','$semester','$tahun_ajaran')");
    
  if ($insert){
    echo '<div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
      <h5><i class="icon fas fa-info"></i> Info </h5>
      <h4>Berhasil Disimpan</h4></div>';
    echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstra_2511500009">';
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
            <label for="id_ekstra009">ID Ekstrakurikuler</label>
            <input type="text" name="id_ekstra009" id="id_ekstra009" placeholder="Masukkan ID Ekstrakurikuler" class="form-control" maxlength="5">
          </div>
          <div class="form-group">
            <label for="nama_ekstra009">Nama Ekstrakurikuler</label>
            <input type="text" name="nama_ekstra009" id="nama_ekstra009" placeholder="Nama Ekstrakurikuler" class="form-control">
          </div>
          <div class="form-group">
            <label for="ket009">Keterangan</label>
            <textarea type= "text" name="ket009" id="ket009" placeholder="Keterangan" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label for="semester009">Semester</label>
            <select name="semester009" id="semester009" placeholder="Masukkan Semester" class="form-control">
                 <option value="">-- Pilih Semester --</option>
                  <option value="1">Semester 1</option>
              <option value="2">Semester 2</option>
              <option value="3">Semester 3</option>
              <option value="4">Semester 4</option>
              <option value="5">Semester 5</option>
              <option value="6">Semester 6</option>
            </select>

          </div>
          <div class="form-group">
            <label for="thn_ajaran009">Tahun Ajaran</label>
            <select type="text" name="thn_ajaran009" id="thn_ajaran009" placeholder="Tahun Ajaran" class="form-control">
                <option value="">-- Pilih Tahun Ajaran --</option>
              <option value="2024/2025">2024/2025</option>
              <option value="2025/2026">2025/2026</option>
              <option value="2026/2027">2026/2027</option>
            </select>
          </div>
          
          <div class="card-footer">
            <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php?page=ekstra_2511500009'">Kembali</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
