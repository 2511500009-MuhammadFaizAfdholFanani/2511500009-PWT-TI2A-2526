<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Kelas</h1>
            </div>
        </div>
    </div>
</div>

<?php
// Ambil data berdasarkan Id_kelas dari parameter GET
$kd = $_GET['kd'];
$edit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kelas WHERE Id_kelas='$kd'"));

// Proses update data kelas
if(isset($_POST['tambah'])){
    $id_kelas = $_POST['id_kelas'];
    $nm_kelas = $_POST['nm_kelas'];

    $update = mysqli_query($koneksi,"UPDATE kelas SET Nm_kelas='$nm_kelas' WHERE Id_kelas='$id_kelas' ");
    if($update){
        echo '<div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=kelas">';
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
            <div class="card-body">
                <div class="card-body p-2">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="id_kelas">ID Kelas</label>
                            <input type="text" name="id_kelas" value="<?= $edit['Id_kelas']; ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nm_kelas">Nama Kelas</label>
                            <input type="text" name="nm_kelas" value="<?= $edit['Nm_kelas']; ?>" id="nm_kelas" placeholder="Nama kelas" class="form-control">
                        </div>
                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
