<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Guru</h1>
            </div>
        </div>
    </div>
</div>

<?php
// Ambil data berdasarkan kd_guru dari parameter GET
$kd = $_GET['kd'];
$edit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM guru WHERE kd_guru='$kd'"));

// Proses update data guru
if(isset($_POST['simpan'])){
    $kd_guru       = $_POST['kd_guru'];
    $nm_guru       = $_POST['nm_guru'];
    $jenkel        = $_POST['jenkel'];
    $pend_terakhir = $_POST['pend_terakhir'];
    $hp            = $_POST['hp'];
    $alamat        = $_POST['alamat'];

    $update = mysqli_query($koneksi,"UPDATE guru 
                                     SET nm_guru='$nm_guru', jenkel='$jenkel', pend_terakhir='$pend_terakhir', hp='$hp', alamat='$alamat' 
                                     WHERE kd_guru='$kd_guru' ");
    if($update){
        echo '<div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=guru">';
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
                        <label for="kd_guru">Kode Guru</label>
                        <input type="text" name="kd_guru" value="<?= $edit['kd_guru']; ?>" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nm_guru">Nama Guru</label>
                        <input type="text" name="nm_guru" value="<?= $edit['nm_guru']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="jenkel">Jenis Kelamin</label>
                        <select name="jenkel" class="form-control">
                            <option value="Laki-laki" <?= ($edit['jenkel']=='Laki-laki')?'selected':''; ?>>Laki-laki</option>
                            <option value="Perempuan" <?= ($edit['jenkel']=='Perempuan')?'selected':''; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pend_terakhir">Pendidikan Terakhir</label>
                        <input type="text" name="pend_terakhir" value="<?= $edit['pend_terakhir']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="hp">HP</label>
                        <input type="text" name="hp" value="<?= $edit['hp']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" value="<?= $edit['alamat']; ?>" class="form-control">
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" name="simpan" value="simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
