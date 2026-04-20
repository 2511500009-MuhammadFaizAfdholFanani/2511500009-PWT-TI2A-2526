<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Siswa</h1>
            </div>
        </div>
    </div>
</div>

<?php
// Ambil data berdasarkan NIS dari parameter GET
$nis = $_GET['nis'];
$edit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM siswa WHERE nis='$nis'"));

// Proses update data siswa
if(isset($_POST['simpan'])){
    $nis        = $_POST['nis'];
    $nm_siswa   = $_POST['nm_siswa'];
    $jenkel     = $_POST['jenkel'];
    $hp         = $_POST['hp'];
    $id_kelas   = $_POST['id_kelas'];

    $update = mysqli_query($koneksi,"UPDATE siswa 
                                     SET nm_siswa='$nm_siswa', jenkel='$jenkel', hp='$hp', Id_kelas='$id_kelas' 
                                     WHERE nis='$nis' ");
    if($update){
        echo '<div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=siswa">';
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
                        <label for="nis">NIS</label>
                        <input type="text" name="nis" value="<?= $edit['nis']; ?>" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nm_siswa">Nama Siswa</label>
                        <input type="text" name="nm_siswa" value="<?= $edit['nm_siswa']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="jenkel">Jenis Kelamin</label>
                        <select name="jenkel" class="form-control">
                            <option value="Laki-laki" <?= ($edit['jenkel']=='Laki-laki')?'selected':''; ?>>Laki-laki</option>
                            <option value="Perempuan" <?= ($edit['jenkel']=='Perempuan')?'selected':''; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="hp">HP</label>
                        <input type="text" name="hp" value="<?= $edit['hp']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="id_kelas">Kelas</label>
                        <select name="id_kelas" class="form-control">
                            <?php
                            $query_kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
                            while ($row_kelas = mysqli_fetch_array($query_kelas)) {
                                $selected = ($row_kelas['Id_kelas'] == $edit['Id_kelas']) ? 'selected' : '';
                                echo '<option value="'.$row_kelas['Id_kelas'].'" '.$selected.'>'.$row_kelas['Nm_kelas'].'</option>';
                            }
                            ?>
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
