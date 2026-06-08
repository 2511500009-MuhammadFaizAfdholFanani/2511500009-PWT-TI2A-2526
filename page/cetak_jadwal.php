<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cetak Jadwal Pelajaran</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: Arial, sans-serif;
      font-size: 12pt;
      background: #f4f4f4;
      padding: 20px;
    }

    .container {
      background: #fff;
      max-width: 800px;
      margin: 0 auto;
      padding: 30px;
      border: 1px solid #ccc;
    }


    .header {
      text-align: center;
      border-bottom: 3px double #000;
      padding-bottom: 10px;
      margin-bottom: 16px;
    }
    .header h2 {
      font-size: 15pt;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .header p {
      font-size: 11pt;
      margin-top: 4px;
    }


    .info-kelas {
      margin-bottom: 14px;
      font-size: 11pt;
    }
    .info-kelas table { border: none; }
    .info-kelas td { padding: 2px 6px 2px 0; border: none; }
    .info-kelas td:first-child { width: 130px; }
    .info-kelas td:nth-child(2) { width: 10px; }


    table.jadwal {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
      font-size: 11pt;
    }
    table.jadwal th {
      background-color: #222;
      color: #fff;
      padding: 7px 10px;
      text-align: center;
      border: 1px solid #000;
    }
    table.jadwal td {
      border: 1px solid #555;
      padding: 6px 10px;
      vertical-align: middle;
    }
    table.jadwal tr:nth-child(even) td { background-color: #f9f9f9; }
    table.jadwal td.hari {
      font-weight: bold;
      text-align: center;
      background-color: #eaeaea;
    }
    table.jadwal td.hari-jumat { background-color: #fff8dc; }


    .ttd {
      margin-top: 30px;
      text-align: right;
      font-size: 11pt;
    }
    .ttd .ttd-box { display: inline-block; min-width: 200px; }
    .ttd .ttd-box .garis {
      margin-top: 60px;
      border-top: 1px solid #000;
      padding-top: 4px;
    }


    .no-print {
      text-align: center;
      margin-bottom: 20px;
    }
    .no-print button {
      padding: 8px 24px;
      font-size: 12pt;
      background: #28a745;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin: 0 6px;
    }
    .no-print button.btn-back {
      background: #6c757d;
    }
    .no-print button:hover { opacity: 0.88; }

    /* ── MEDIA PRINT ── */
    @media print {
      body { background: #fff; padding: 0; }
      .container { border: none; padding: 10px; max-width: 100%; }
      .no-print { display: none !important; }
      table.jadwal th { background-color: #222 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
      table.jadwal td.hari { background-color: #eaeaea !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
      table.jadwal td.hari-jumat { background-color: #fff8dc !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
  </style>
</head>
<body>

<?php
include "config/koneksi.php";

$kd = isset($_GET['kd']) ? (int)$_GET['kd'] : 0;

if ($kd == 0) {
    echo '<p style="text-align:center;margin-top:40px">ID Jadwal tidak valid.</p>';
    exit;
}

$info = mysqli_fetch_array(mysqli_query($koneksi,
    "SELECT j.id_jadwal, j.thn_ajaran, j.semester,
            k.Nm_kelas
     FROM jadwal j
     JOIN kelas k ON k.Id_kelas = j.id_kelas
     WHERE j.id_jadwal = '$kd'
     LIMIT 1"
));

if (!$info) {
    echo '<p style="text-align:center;margin-top:40px">Data jadwal tidak ditemukan.</p>';
    exit;
}

$detail = mysqli_query($koneksi,
    "SELECT dj.hari, dj.jam_mulai, dj.jam_selesai,
            m.nm_mapel, g.nm_guru
     FROM detail_jadwal dj
     JOIN mapel m ON m.kd_mapel = dj.kd_mapel
     JOIN guru  g ON g.kd_guru  = dj.kd_guru
     WHERE dj.id_jadwal = '$kd'
     ORDER BY FIELD(dj.hari,'senin','selasa','rabu','kamis','jumat','sabtu'),
              dj.jam_mulai"
);

$per_hari    = [];
$urutan_hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

while ($row = mysqli_fetch_array($detail)) {
    $hari = ucfirst(strtolower($row['hari']));
    $per_hari[$hari][] = $row;
}
?>

<div class="container">


  <div class="no-print">
    <button onclick="window.print()">&#128438; Cetak / Simpan PDF</button>
    <button class="btn-back" onclick="window.close()">&#8592; Kembali</button>
  </div>

  <div class="header">
    <h2>Jadwal Pelajaran</h2>
    <p>Sistem Informasi Akademik</p>
  </div>

  <div class="info-kelas">
    <table>
      <tr>
        <td>Kelas</td>
        <td>:</td>
        <td><strong><?= htmlspecialchars($info['Nm_kelas']); ?></strong></td>
      </tr>
      <tr>
        <td>Tahun Ajaran</td>
        <td>:</td>
        <td><?= htmlspecialchars($info['thn_ajaran']); ?></td>
      </tr>
      <tr>
        <td>Semester</td>
        <td>:</td>
        <td><?= ucfirst($info['semester']); ?></td>
      </tr>
    </table>
  </div>


  <?php if (empty($per_hari)): ?>
  <p style="text-align:center;padding:20px;color:#888">
  </p>
  <?php else: ?>
  <table class="jadwal">
    <thead>
      <tr>
        <th width="70">Hari</th>
        <th width="130">Jam</th>
        <th>Mata Pelajaran</th>
        <th>Guru Pengampu</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($urutan_hari as $hari):
        if (!isset($per_hari[$hari])) continue;
        $rowspan = count($per_hari[$hari]);
        $first   = true;
        $isJumat = ($hari === 'Jumat');
        foreach ($per_hari[$hari] as $item):
          $jam = substr($item['jam_mulai'],0,5).' s.d. '.substr($item['jam_selesai'],0,5);
      ?>
      <tr>
        <?php if ($first): ?>
        <td rowspan="<?= $rowspan; ?>"
            class="hari <?= $isJumat ? 'hari-jumat' : ''; ?>">
          <?= $hari; ?>
        </td>
        <?php $first = false; endif; ?>
        <td style="text-align:center"><?= $jam; ?></td>
        <td><?= htmlspecialchars($item['nm_mapel']); ?></td>
        <td><?= htmlspecialchars($item['nm_guru']); ?></td>
      </tr>
      <?php endforeach; endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>

  <div class="ttd">
    <div class="ttd-box">
      <p>Mengetahui,</p>
      <p>Kepala Sekolah</p>
      <div class="garis">
        <p>( _________________________ )</p>
      </div>
    </div>
  </div>

</div><!-- /.container -->
</body>
</html>