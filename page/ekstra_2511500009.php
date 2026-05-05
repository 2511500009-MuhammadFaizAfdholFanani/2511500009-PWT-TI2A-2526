<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Ekstrakurikuler</h1>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_GET['action'])) {
    if($_GET['action'] == "hapus") {
        $id_ekstra = $_GET['id_ekstra'];
        $query = mysqli_query($koneksi, "DELETE FROM ekstra_2511500009 WHERE id_ekstra009 = '$id_ekstra' ");
        if ($query){
            echo '
            <div class="alert alert-warning alert-dismissible">
            Berhasil Di Hapus</div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstra_2511500009">';
        }
    }
}
?>

<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <a href="index.php?page=tambah_ekstra2511500009" class="btn btn-primary btn-sm">Tambah Ekstrakurikuler</a>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>NO</th>
              <th>ID Ekstrakurikuler</th>
              <th>Nama Ekstrakulikuler</th>
              <th>Keterangan</th>
              <th>Semester</th>
              <th>Tahun ajaran</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            $query = mysqli_query($koneksi, "SELECT * FROM ekstra_2511500009");
            while ($result = mysqli_fetch_array($query)) {
              $no++;
            ?>
            <tr>
              <td><?= $no; ?></td>
              <td><?= $result['id_ekstra009']; ?></td>
              <td><?= $result['nama_ekstra009']; ?></td>
              <td><?= $result['ket009']; ?></td>
              <td><?= $result['semester009']; ?></td>
              <td><?= $result['thn_ajaran009']; ?></td>
              <td>
                <a href="index.php?page=ekstra_2511500009&action=hapus&id_ekstra=<?= $result['id_ekstra009'] ?>" title="">
                  <span class="badge badge-danger">Hapus</span></a>
                <a href="index.php?page=edit_ekstra2511500009&id_ekstra=<?= $result['id_ekstra009'] ?>" title="">
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
