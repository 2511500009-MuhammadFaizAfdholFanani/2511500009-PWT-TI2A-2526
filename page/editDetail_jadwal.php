<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Detail Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<?php
// ─── 1. Ambil parameter composite key dari URL ───────────────────────────────
$id_jadwal = isset($_GET['id_jadwal']) ? $_GET['id_jadwal'] : 0;
$kd_mapel  = isset($_GET['kd_mapel'])  ? $_GET['kd_mapel']  : '';
$kd_guru   = isset($_GET['kd_guru'])   ? $_GET['kd_guru']   : '';

// ─── 2. Fetch baris yang akan diedit ────────────────────────────────────────
$stmt = mysqli_prepare($koneksi,
    "SELECT * FROM detail_jadwal
     WHERE id_jadwal = ? AND kd_mapel = ? AND kd_guru = ?
     LIMIT 1"
);
mysqli_stmt_bind_param($stmt, 'iss', $id_jadwal, $kd_mapel, $kd_guru);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$edit   = mysqli_fetch_array($result);
mysqli_stmt_close($stmt);

// Redirect jika data tidak ditemukan
if (!$edit) {
    echo '<div class="alert alert-danger">Data tidak ditemukan.</div>';
    echo '<meta http-equiv="refresh" content="2;url=index.php?page=jadwal">';
    return;
}

// ─── 3. Proses simpan ketika form di-submit ──────────────────────────────────
if (isset($_POST['simpan'])) {
    $hari        = $_POST['hari'];
    $jam_mulai   = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $kd_mapel_baru = $_POST['kd_mapel'];
    $kd_guru_baru  = $_POST['kd_guru'];

    $upd = mysqli_prepare($koneksi,
        "UPDATE detail_jadwal
         SET hari = ?, jam_mulai = ?, jam_selesai = ?,
             kd_mapel = ?, kd_guru = ?
         WHERE id_jadwal = ? AND kd_mapel = ? AND kd_guru = ?"
    );
    mysqli_stmt_bind_param($upd, 'sssssiss',
        $hari, $jam_mulai, $jam_selesai,
        $kd_mapel_baru, $kd_guru_baru,
        $id_jadwal, $kd_mapel, $kd_guru
    );
    $exec = mysqli_stmt_execute($upd);
    mysqli_stmt_close($upd);

    if ($exec) {
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-info"></i> Info</h5>
                <h4>Berhasil Disimpan</h4>
              </div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=detail_jadwal&kd=' . $id_jadwal . '">';
    } else {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-info"></i> Info</h5>
                <h4>Gagal Disimpan</h4>
              </div>';
    }
}

// ─── 4. Helper: nilai hari untuk selected ────────────────────────────────────
$hari_list = ['senin','selasa','rabu','kamis','jumat','sabtu'];
?>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-2">
                <form method="POST" action="">

                    <!-- ID Jadwal (readonly, seperti ID di edit_ekstra) -->
                    <div class="form-group">
                        <label for="id_jadwal">ID Jadwal</label>
                        <input type="number" name="id_jadwal" id="id_jadwal"
                               class="form-control"
                               value="<?= htmlspecialchars($edit['id_jadwal']); ?>" readonly>
                    </div>

                    <!-- Dropdown Mata Pelajaran (pre-selected) -->
                    <div class="form-group">
                        <label for="kd_mapel">Mata Pelajaran</label>
                        <select name="kd_mapel" id="kd_mapel" class="form-control" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            <?php
                            $query_mapel = mysqli_query($koneksi, "SELECT * FROM mapel ORDER BY nm_mapel");
                            while ($row_mapel = mysqli_fetch_array($query_mapel)) {
                                $selected = ($row_mapel['kd_mapel'] == $edit['kd_mapel']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($row_mapel['kd_mapel']) . '" ' . $selected . '>'
                                   . htmlspecialchars($row_mapel['kd_mapel']) . ' - '
                                   . htmlspecialchars($row_mapel['nm_mapel'])
                                   . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Dropdown Guru (pre-selected) -->
                    <div class="form-group">
                        <label for="kd_guru">Guru</label>
                        <select name="kd_guru" id="kd_guru" class="form-control" required>
                            <option value="">-- Pilih Guru --</option>
                            <?php
                            $query_guru = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY Nm_guru");
                            while ($row_guru = mysqli_fetch_array($query_guru)) {
                                $selected = ($row_guru['kd_guru'] == $edit['kd_guru']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($row_guru['kd_guru']) . '" ' . $selected . '>'
                                   . htmlspecialchars($row_guru['kd_guru']) . '  '
                                   . htmlspecialchars($row_guru['Nm_guru'])
                                   . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Dropdown Hari (pre-selected) -->
                    <div class="form-group">
                        <label for="hari">Hari</label>
                        <select name="hari" id="hari" class="form-control" required>
                            <option value="">-- Pilih Hari --</option>
                            <?php foreach ($hari_list as $h): ?>
                            <option value="<?= $h; ?>"
                                <?= (strtolower($edit['hari']) === $h) ? 'selected' : ''; ?>>
                                <?= ucfirst($h); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Jam Mulai (pre-filled, format HH:MM) -->
                    <div class="form-group">
                        <label for="jam_mulai">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="jam_mulai"
                               class="form-control"
                               value="<?= substr($edit['jam_mulai'], 0, 5); ?>" required>
                    </div>

                    <!-- Jam Selesai (pre-filled, format HH:MM) -->
                    <div class="form-group">
                        <label for="jam_selesai">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="jam_selesai"
                               class="form-control"
                               value="<?= substr($edit['jam_selesai'], 0, 5); ?>" required>
                    </div>

                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" name="simpan" value="Simpan">
                        <button type="button" class="btn btn-secondary"
                                onclick="window.location.href='index.php?page=detail_jadwal&kd=<?= $id_jadwal; ?>'">
                            Kembali
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>