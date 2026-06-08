<?php
if (!isset($_SESSION['Role']) || $_SESSION['Role'] !== 'siswa') {
    echo '<div class="alert alert-danger"><i class="fas fa-lock mr-2"></i>Akses ditolak. Halaman ini hanya untuk Siswa.</div>';
    return;
}

// Ambil id_kelas dari session (jika sudah ada)
$id_kelas = isset($_SESSION['id_kelas']) ? $_SESSION['id_kelas'] : '';
$nm_siswa = isset($_SESSION['nm_siswa']) ? $_SESSION['nm_siswa'] : '';
$nm_kelas = isset($_SESSION['nm_kelas']) ? $_SESSION['nm_kelas'] : '';

// Fallback: cari dari tabel siswa berdasarkan Username (cocokkan ke nm_siswa)
if (empty($id_kelas)) {
    $usernameSession = mysqli_real_escape_string($koneksi, $_SESSION['Username']);
    $sqlSiswa = "SELECT s.nis, s.nm_siswa, s.id_kelas, k.Nm_kelas
                 FROM siswa s
                 JOIN kelas k ON k.Id_kelas = s.id_kelas
                 WHERE s.nm_siswa LIKE '%$usernameSession%'
                 LIMIT 1";
    $resSiswa = mysqli_query($koneksi, $sqlSiswa);
    if ($resSiswa) {
        $dataSiswa = mysqli_fetch_assoc($resSiswa);
        if ($dataSiswa) {
            $id_kelas = $dataSiswa['id_kelas'];
            $nm_siswa = $dataSiswa['nm_siswa'];
            $nm_kelas = $dataSiswa['Nm_kelas'];
            $_SESSION['id_kelas'] = $id_kelas;
            $_SESSION['nm_siswa'] = $nm_siswa;
            $_SESSION['nm_kelas'] = $nm_kelas;
        }
    }
}

if (empty($id_kelas)) {
    echo '<div class="alert alert-warning">';
    echo '<i class="fas fa-exclamation-triangle mr-2"></i>';
    echo 'Data siswa tidak ditemukan. Pastikan <strong>Username</strong> di tabel <strong>users</strong> sama dengan <strong>nm_siswa</strong> di tabel <strong>siswa</strong>.';
    echo '</div>';
    return;
}

// Ambil jadwal berdasarkan id_kelas
$id_kelas_esc = mysqli_real_escape_string($koneksi, $id_kelas);
$query = mysqli_query($koneksi,
    "SELECT dj.hari, dj.jam_mulai, dj.jam_selesai,
            m.nm_mapel,
            g.nm_guru,
            j.thn_ajaran, j.semester
     FROM jadwal j
     JOIN detail_jadwal dj ON dj.id_jadwal = j.id_jadwal
     JOIN mapel  m ON m.kd_mapel = dj.kd_mapel
     JOIN guru   g ON g.kd_guru  = dj.kd_guru
     WHERE j.id_kelas = '$id_kelas_esc'
     ORDER BY FIELD(dj.hari,'senin','selasa','rabu','kamis','jumat','sabtu'),
              dj.jam_mulai"
);

$jadwal_per_hari = [];
while ($row = mysqli_fetch_assoc($query)) {
    $hari = ucfirst(strtolower($row['hari']));
    $jadwal_per_hari[$hari][] = $row;
}
$urutan_hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Jadwal Kelas Saya</h1>
      </div>
      <div class="col-sm-6">
        <p class="float-sm-right text-muted mt-2">
          <i class="fas fa-user-graduate mr-1"></i>
          <?= htmlspecialchars($nm_siswa); ?>
          <span class="badge badge-primary ml-1"><?= htmlspecialchars($nm_kelas); ?></span>
        </p>
      </div>
    </div>
  </div>
</div>

<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-calendar-week mr-1"></i>
          Jadwal Pelajaran
        </h3>
      </div>
      <div class="card-body p-0">

        <?php if (empty($jadwal_per_hari)): ?>
        <div class="p-4">
          <div class="alert alert-info mb-0">
            <i class="fas fa-info-circle mr-1"></i>
            Belum ada jadwal pelajaran yang tersedia untuk kelas Anda.
          </div>
        </div>

        <?php else:
          $total_jam   = 0;
          $total_mapel = [];
          foreach ($jadwal_per_hari as $h => $items) {
              $total_jam += count($items);
              foreach ($items as $i) $total_mapel[$i['nm_mapel']] = true;
          }
        ?>
        <div class="row text-center border-bottom py-3 mx-0">
          <div class="col-4">
            <div class="font-weight-bold text-primary" style="font-size:1.5rem"><?= $total_jam; ?></div>
            <small class="text-muted">Total Jam Pelajaran</small>
          </div>
          <div class="col-4">
            <div class="font-weight-bold text-success" style="font-size:1.5rem"><?= count($jadwal_per_hari); ?></div>
            <small class="text-muted">Hari Aktif</small>
          </div>
          <div class="col-4">
            <div class="font-weight-bold text-warning" style="font-size:1.5rem"><?= count($total_mapel); ?></div>
            <small class="text-muted">Mata Pelajaran</small>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover mb-0">
            <thead class="thead-dark">
              <tr>
                <th width="90">Hari</th>
                <th width="130">Jam</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
                <th>Tahun Ajaran</th>
                <th>Semester</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($urutan_hari as $hari):
                if (!isset($jadwal_per_hari[$hari])) continue;
                $rowspan = count($jadwal_per_hari[$hari]);
                $first   = true;
                $warna   = ($hari == 'Jumat') ? 'table-warning' : '';
                foreach ($jadwal_per_hari[$hari] as $item):
                  $jam = substr($item['jam_mulai'],0,5).' s.d '.substr($item['jam_selesai'],0,5);
              ?>
              <tr>
                <?php if ($first): ?>
                <td rowspan="<?= $rowspan; ?>"
                    class="font-weight-bold text-center align-middle <?= $warna; ?>">
                  <?= $hari; ?>
                </td>
                <?php $first = false; endif; ?>
                <td class="text-center"><?= $jam; ?></td>
                <td><?= htmlspecialchars($item['nm_mapel']); ?></td>
                <td><span class="badge badge-secondary"><?= htmlspecialchars($item['nm_guru']); ?></span></td>
                <td><?= htmlspecialchars($item['thn_ajaran']); ?></td>
                <td><?= ucfirst($item['semester']); ?></td>
              </tr>
              <?php endforeach; endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>