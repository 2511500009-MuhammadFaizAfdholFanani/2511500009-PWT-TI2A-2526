<?php
if (!isset($_SESSION['Role']) || $_SESSION['Role'] !== 'guru') {
    echo '<div class="alert alert-danger"><i class="fas fa-lock mr-2"></i>Akses ditolak. Halaman ini hanya untuk Guru.</div>';
    return;
}

// Ambil kd_guru dari session (sudah disimpan saat login)
$kd_guru = isset($_SESSION['kd_guru']) ? $_SESSION['kd_guru'] : '';
$nm_guru = isset($_SESSION['nm_guru']) ? $_SESSION['nm_guru'] : $_SESSION['Username'];

// Fallback: jika session kd_guru belum ada, cari dari nm_guru berdasarkan Username
if (empty($kd_guru)) {
    $usernameSession = $_SESSION['Username'];
    $sqlGuru = "SELECT kd_guru, nm_guru FROM guru WHERE nm_guru LIKE '%$usernameSession%' LIMIT 1";
    $resGuru = mysqli_query($koneksi, $sqlGuru);
    if ($resGuru) {
        $dataGuru = mysqli_fetch_array($resGuru);
        if ($dataGuru) {
            $kd_guru = $dataGuru['kd_guru'];
            $nm_guru = $dataGuru['nm_guru'];
            // Simpan ke session untuk request berikutnya
            $_SESSION['kd_guru'] = $kd_guru;
            $_SESSION['nm_guru'] = $nm_guru;
        }
    }
}

if (empty($kd_guru)) {
    echo '<div class="alert alert-warning">';
    echo '<i class="fas fa-exclamation-triangle mr-2"></i>';
    echo 'Data guru tidak ditemukan. Pastikan nama Username di tabel <strong>users</strong> sama dengan nama di tabel <strong>guru</strong>.';
    echo '</div>';
    return;
}

// Ambil jadwal mengajar guru
$query = mysqli_query($koneksi,
    "SELECT dj.id_jadwal, dj.hari, dj.jam_mulai, dj.jam_selesai,
            m.nm_mapel,
            k.Nm_kelas,
            j.thn_ajaran, j.semester
     FROM detail_jadwal dj
     JOIN mapel  m ON m.kd_mapel  = dj.kd_mapel
     JOIN jadwal j ON j.id_jadwal = dj.id_jadwal
     JOIN kelas  k ON k.Id_kelas  = j.id_kelas
     WHERE dj.kd_guru = '$kd_guru'
     ORDER BY FIELD(dj.hari,'senin','selasa','rabu','kamis','jumat','sabtu'),
              dj.jam_mulai"
);

$jadwal_per_hari = [];
while ($row = mysqli_fetch_array($query)) {
    $hari = ucfirst(strtolower($row['hari']));
    $jadwal_per_hari[$hari][] = $row;
}
$urutan_hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Jadwal Mengajar Saya</h1>
      </div>
      <div class="col-sm-6">
        <p class="float-sm-right text-muted mt-2">
          <i class="fas fa-chalkboard-teacher mr-1"></i>
          <?= htmlspecialchars($nm_guru); ?>
          <span class="badge badge-secondary ml-1"><?= htmlspecialchars($kd_guru); ?></span>
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
          Jadwal Minggu Ini
        </h3>
      </div>
      <div class="card-body p-0">

        <?php if (empty($jadwal_per_hari)): ?>
        <div class="p-4">
          <div class="alert alert-info mb-0">
            <i class="fas fa-info-circle mr-1"></i>
            Belum ada jadwal mengajar yang tersedia.
          </div>
        </div>

        <?php else:
          $total_jam   = 0;
          $total_kelas = [];
          foreach ($jadwal_per_hari as $h => $items) {
              $total_jam += count($items);
              foreach ($items as $i) $total_kelas[$i['Nm_kelas']] = true;
          }
        ?>
        <div class="row text-center border-bottom py-3 mx-0">
          <div class="col-4">
            <div class="font-weight-bold text-primary" style="font-size:1.5rem"><?= $total_jam; ?></div>
            <small class="text-muted">Total Jam Mengajar</small>
          </div>
          <div class="col-4">
            <div class="font-weight-bold text-success" style="font-size:1.5rem"><?= count($jadwal_per_hari); ?></div>
            <small class="text-muted">Hari Aktif</small>
          </div>
          <div class="col-4">
            <div class="font-weight-bold text-warning" style="font-size:1.5rem"><?= count($total_kelas); ?></div>
            <small class="text-muted">Kelas Diajar</small>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover mb-0">
            <thead class="thead-dark">
              <tr>
                <th width="90">Hari</th>
                <th width="130">Jam</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
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
                <td><span class="badge badge-primary"><?= htmlspecialchars($item['Nm_kelas']); ?></span></td>
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