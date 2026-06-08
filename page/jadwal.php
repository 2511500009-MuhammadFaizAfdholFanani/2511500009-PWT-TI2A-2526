<?php
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $kd = $_GET['kd'];
    mysqli_query($koneksi, "DELETE FROM detail_jadwal WHERE id_jadwal = '$kd'");
    $hapus = mysqli_query($koneksi, "DELETE FROM jadwal WHERE id_jadwal = '$kd'");
    if ($hapus) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data jadwal telah dihapus.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal">';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Tidak dapat menghapus data.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
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
        <a href="index.php?page=tambah_jadwal" class="btn btn-primary btn-sm mb-3">
          <i class="fas fa-plus"></i> Tambah Jadwal
        </a>
        <table class="table table-bordered table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No</th>
              <th>Kode Jadwal</th>
              <th>Kelas</th>
              <th>Semester</th>
              <th>Tahun Ajaran</th>
              <th>Detail Jadwal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            $query = mysqli_query($koneksi,
                "SELECT j.id_jadwal, j.thn_ajaran, j.semester, k.Nm_kelas
                 FROM jadwal j
                 LEFT JOIN kelas k ON j.id_kelas = k.Id_kelas
                 ORDER BY j.id_jadwal ASC"
            );
            while ($row = mysqli_fetch_assoc($query)) {
                $no++;
            ?>
            <tr>
              <td><?= $no ?></td>
              <td><?= $row['id_jadwal'] ?></td>
              <td><?= $row['Nm_kelas'] ?? '-' ?></td>
              <td><?= ucfirst($row['semester']) ?></td>
              <td><?= $row['thn_ajaran'] ?></td>
              <td>
                <ul class="mb-0 pl-3">
                  <?php
                  $det = mysqli_query($koneksi,
                      "SELECT dj.hari, dj.jam_mulai, dj.jam_selesai, m.nm_mapel, g.nm_guru
                       FROM detail_jadwal dj
                       JOIN mapel m ON dj.kd_mapel = m.kd_mapel
                       JOIN guru g ON dj.kd_guru = g.kd_guru
                       WHERE dj.id_jadwal = '{$row['id_jadwal']}'"
                  );
                  while ($d = mysqli_fetch_assoc($det)) {
                      echo "<li>{$d['nm_mapel']} - {$d['hari']} - {$d['jam_mulai']} s/d {$d['jam_selesai']} - {$d['nm_guru']}</li>";
                  }
                  ?>
                </ul>
              </td>
              <td>
                <a href="index.php?page=jadwal&action=hapus&kd=<?= $row['id_jadwal'] ?>"
                   onclick="return confirm('Yakin ingin menghapus jadwal ini beserta semua detailnya?')"
                   class="btn btn-danger btn-sm">
                  <i class="fas fa-trash"></i> Hapus
                </a>
                <a href="index.php?page=cetak_jadwal&kd=<?= $row['id_jadwal'] ?>"
                   class="btn btn-success btn-sm" target="_blank">
                  <i class="fas fa-print"></i> Cetak
                </a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>