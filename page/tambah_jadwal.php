<?php
$carikode = mysqli_query($koneksi, "SELECT MAX(id_jadwal) FROM jadwal") or die(mysqli_error($koneksi));
$datakode = mysqli_fetch_array($carikode);
$hasilkode = $datakode[0] ? (int)$datakode[0] + 1 : 1;
$_SESSION["KODE"] = $hasilkode;

if (isset($_POST['tambah'])) {
    $id_kelas   = $_POST['id_kelas'];
    $thn_ajaran = $_POST['thn_ajaran'];
    $semester   = $_POST['semester'];

    $insertJadwal = mysqli_query($koneksi,
        "INSERT INTO jadwal (id_kelas, thn_ajaran, semester)
         VALUES ('$id_kelas','$thn_ajaran','$semester')"
    );

    if (!$insertJadwal) {
        echo '<div class="alert alert-danger">Gagal insert jadwal: ' . mysqli_error($koneksi) . '</div>';
        die;
    }

    $id_jadwal_baru = mysqli_insert_id($koneksi);
    $kd_mapel    = $_POST['kd_mapel'];
    $hari        = $_POST['hari'];
    $jam_mulai   = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $kd_guru     = $_POST['kd_guru'];

    $allSuccess = true;
    for ($i = 0; $i < count($kd_mapel); $i++) {
        $ins = mysqli_query($koneksi,
            "INSERT INTO detail_jadwal (id_jadwal, kd_mapel, kd_guru, hari, jam_mulai, jam_selesai)
             VALUES ('$id_jadwal_baru','{$kd_mapel[$i]}','{$kd_guru[$i]}','{$hari[$i]}','{$jam_mulai[$i]}','{$jam_selesai[$i]}')"
        );
        if (!$ins) { $allSuccess = false; }
    }

    if ($allSuccess) {
        echo '<div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                <h5><i class="icon fas fa-info"></i> Info </h5>
                <h4>Berhasil Disimpan</h4>
              </div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal">';
    } else {
        echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                <h5><i class="icon fas fa-info"></i> Info </h5>
                <h4>Gagal menyimpan sebagian atau seluruh data detail.</h4>
              </div>';
    }
}
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Data Jadwal</h1>
      </div>
    </div>
  </div>
</div>

<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <h3>Tambah Jadwal</h3>
        <form method="POST" action="">

          <div class="form-group">
            <label>Kode Jadwal</label>
            <input type="text" class="form-control" value="<?= $hasilkode ?>" readonly>
          </div>

          <div class="form-group">
            <label>Kelas</label>
            <select name="id_kelas" class="form-control" required>
              <option value="">-- Pilih Kelas --</option>
              <?php
              $qKelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY Nm_kelas");
              while ($rKelas = mysqli_fetch_assoc($qKelas)) {
                echo '<option value="'.$rKelas['Id_kelas'].'">'.$rKelas['Nm_kelas'].'</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label>Semester</label>
            <select name="semester" class="form-control" required>
              <option value="" disabled selected>--Pilih semester--</option>
              <option value="ganjil">Ganjil</option>
              <option value="genap">Genap</option>
            </select>
          </div>

          <div class="form-group">
            <label>Tahun Ajaran</label>
            <select name="thn_ajaran" class="form-control" required>
              <option value="" disabled selected>--Pilih Tahun Ajaran--</option>
              <option value="2023/2024">2023/2024</option>
              <option value="2024/2025">2024/2025</option>
              <option value="2025/2026">2025/2026</option>
              <option value="2026/2027">2026/2027</option>
            </select>
          </div>

          <hr>
          <h5>Detail Jadwal</h5>

          <div id="detail-jadwal">
            <div class="row mb-2 baris-detail">
              <div class="col-md-2">
                <select name="kd_mapel[]" class="form-control">
                  <option value="">--Pilih Mapel--</option>
                  <?php
                  $qMapel = mysqli_query($koneksi, "SELECT * FROM mapel ORDER BY nm_mapel");
                  while ($rMapel = mysqli_fetch_assoc($qMapel)) {
                    echo '<option value="'.$rMapel['kd_mapel'].'">'.$rMapel['nm_mapel'].'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-2">
                <select name="hari[]" class="form-control">
                  <option value="" disabled selected>--Pilih Hari--</option>
                  <option value="Senin">Senin</option>
                  <option value="Selasa">Selasa</option>
                  <option value="Rabu">Rabu</option>
                  <option value="Kamis">Kamis</option>
                  <option value="Jumat">Jumat</option>
                  <option value="Sabtu">Sabtu</option>
                </select>
              </div>
              <div class="col-md-2">
                <select name="jam_mulai[]" class="form-control">
                  <option value="" disabled selected>--Jam Mulai--</option>
                  <option value="07:30:00">07.30</option>
                  <option value="08:15:00">08.15</option>
                  <option value="09:00:00">09.00</option>
                  <option value="10:15:00">10.15</option>
                  <option value="11:00:00">11.00</option>
                  <option value="11:45:00">11.45</option>
                  <option value="13:15:00">13.15</option>
                  <option value="14:00:00">14.00</option>
                  <option value="14:45:00">14.45</option>
                </select>
              </div>
              <div class="col-md-2">
                <select name="jam_selesai[]" class="form-control">
                  <option value="" disabled selected>--Jam Selesai--</option>
                  <option value="08:15:00">08.15</option>
                  <option value="09:00:00">09.00</option>
                  <option value="09:45:00">09.45</option>
                  <option value="11:00:00">11.00</option>
                  <option value="11:45:00">11.45</option>
                  <option value="12:30:00">12.30</option>
                  <option value="14:00:00">14.00</option>
                  <option value="14:45:00">14.45</option>
                  <option value="15:30:00">15.30</option>
                </select>
              </div>
              <div class="col-md-2">
                <select name="kd_guru[]" class="form-control" required>
                  <option value="">-- Pilih Guru --</option>
                  <?php
                  $qGuru = mysqli_query($koneksi, "SELECT kd_guru, nm_guru FROM guru ORDER BY nm_guru");
                  while ($rGuru = mysqli_fetch_assoc($qGuru)) {
                    echo '<option value="'.$rGuru['kd_guru'].'">'.$rGuru['nm_guru'].'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm btn-hapus"
                        style="display:none" onclick="hapusBaris(this)">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
          </div>

          <button type="button" class="btn btn-info btn-sm mb-3" onclick="tambahBaris()">
            + Tambah Mapel
          </button>

          <br><br>

          <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
          <a href="index.php?page=jadwal" class="btn btn-secondary ml-1">Kembali</a>

        </form>
      </div>
    </div>
  </div>
</div>

<script>
function tambahBaris() {
  var container = document.getElementById('detail-jadwal');
  var baru = container.querySelector('.baris-detail').cloneNode(true);
  baru.querySelectorAll('select').forEach(function(s){ s.selectedIndex = 0; });
  var btnHapus = baru.querySelector('.btn-hapus');
  if (btnHapus) btnHapus.style.display = 'inline-block';
  container.appendChild(baru);
}

function hapusBaris(btn) {
  var container = document.getElementById('detail-jadwal');
  if (container.querySelectorAll('.baris-detail').length <= 1) {
    alert('Minimal harus ada 1 mata pelajaran!');
    return;
  }
  btn.closest('.baris-detail').remove();
}
</script>