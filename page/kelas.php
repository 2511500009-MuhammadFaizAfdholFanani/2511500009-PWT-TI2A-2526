<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data kelas</h1>
            </div>
        </div>
    </div>
</div>

<?php
// Proses hapus data kelas  
if(isset($_GET['action'])) {
    if($_GET['action'] == "hapus") {
        $kd = $_GET['kd'];
        $query = mysqli_query($koneksi, "DELETE FROM kelas WHERE kd_kelas = '$kd' ");
        if ($query){
            echo '
            <div class="alert alert-warning alert-dismissible">
            Berhasil Di Hapus</div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=kelas">';
        }
    }
}
?>

<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <a href="index.php?page=tambah_kelas" class="btn btn-primary btn-sm">Tambah Kelas</a>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>NO</th>
              <th>Id kelas</th>
              <th>Nama kelas</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            $query = mysqli_query($koneksi, "SELECT * FROM kelas");
            while ($result = mysqli_fetch_array($query)) {
              $no++;
            ?>
            <tr>
              <td><?= $no; ?></td>
              <td><?= $result['kd_kelas']; ?></td>
              <td><?= $result['nm_kelas']; ?></td>
              <td>
                <a href="index.php?page=kelas&action=hapus&kd=<?= $result['kd_kelas'] ?>" title="">
                  <span class="badge badge-danger">Hapus</span></a>
                <a href="index.php?page=edit_kelas&kd=<?= $result['kd_kelas'] ?>" title="">
                  <span class="badge badge-warning">Edit</span></a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
