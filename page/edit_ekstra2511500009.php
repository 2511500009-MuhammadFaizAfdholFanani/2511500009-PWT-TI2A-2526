<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Ekstrakurikuler</h1>
            </div>
        </div>
    </div>
</div>

<?php
// Ambil data berdasarkan ID dari parameter GET
$id_ekstra = $_GET['id_ekstra'];
$edit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM ekstra_2511500009 WHERE id_ekstra009='$id_ekstra'"));

// Proses update data ekstrakurikuler
if(isset($_POST['simpan'])){
    $id_ekstra        = $_POST['id_ekstra009'];
    $nm_ekstra   = $_POST['nama_ekstra009'];
    $keterangan     = $_POST['ket009'];
    $semester         = $_POST['semester009'];
    $tahun_ajaran   = $_POST['thn_ajaran009'];

    $update = mysqli_query($koneksi,"UPDATE ekstra_2511500009 
                                     SET nama_ekstra009='$nm_ekstra', ket009='$keterangan', semester009='$semester', thn_ajaran009='$tahun_ajaran' 
                                     WHERE id_ekstra009='$id_ekstra' ");
    if($update){
        echo '<div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstra_2511500009">';
    }else{
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
                        <input type="text" name="id_ekstra009" value="<?= $edit['id_ekstra009']; ?>" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_ekstra009">Nama Ekstrakurikuler</label>
                        <input type="text" name="nama_ekstra009" value="<?= $edit['nama_ekstra009']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="ket009">Keterangan</label>
                        <textarea name="ket009" class="form-control"><?= $edit['ket009']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="semester009">Semester</label>
                        <select name="semester009" value="<?= $edit['semester009']; ?>" class="form-control">
                         <option value="">-- Pilih Tahun Ajaran --</option>
                            <option value="1" <?= ($edit['semester009']=='Semester 1')?'selected':''; ?>>Semester 1</option>
                            <option value="2" <?= ($edit['semester009']=='Semester 2')?'selected':''; ?>>Semester 2</option>
                            <option value="3" <?= ($edit['semester009']=='Semester 3')?'selected':''; ?>>Semester 3</option>
                            <option value="4" <?= ($edit['semester009']=='Semester 4')?'selected':''; ?>>Semester 4</option>
                            <option value="5" <?= ($edit['semester009']=='Semester 5')?'selected':''; ?>>Semester 5</option>
                            <option value="6" <?= ($edit['semester009']=='Semester 6')?'selected':''; ?>>Semester 6</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="thn_ajaran009">Tahun Ajaran</label>
                        <select name="thn_ajaran009" class="form-control">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <option value="2024/2025" <?= ($edit['thn_ajaran009']=='2024/2025')?'selected':''; ?>>2024/2025</option>
                            <option value="2025/2026" <?= ($edit['thn_ajaran009']=='2025/2026')?'selected':''; ?>>2025/2026</option>
                            <option value="2026/2027" <?= ($edit['thn_ajaran009']=='2026/2027')?'selected':''; ?>>2026/2027</option>
                        </select>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" name="simpan" value="simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
