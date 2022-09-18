<?php
session_start();
include('config/config.php');
include('config/fungsi.php');
include('page_layout.php');

$sql = "SELECT DISTINCT barang.barang FROM penilaian join barang where penilaian.id_barang = barang.id ORDER BY barang asc";
$res = mysqli_query($koneksi, $sql);
?>
<ol class="breadcrumb py-4">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Penilaian</li>
</ol>
<div class="container-fluid">
    <h3 class="mt-4 mb-4">PENILAIAN</h3>
    <select id="pilih" onchange="selectPenilaian()" class="form-control">
        <option disabled selected>Pilih Barang</option>
        <?php while ($row = mysqli_fetch_array($res)) {
        ?>
            <option value="<?php echo  $row['barang']; ?>"><?php echo  $row['barang'] ?></option>
        <?php } ?>
    </select>
    <button type="button" class="btn btn-secondary mt-5" data-bs-toggle="modal" data-bs-target="#nilaiModal" data-toggle="tooltip" data-placement="bottom" title="Tambah Data Penilaian">
        <i class="fa fa-plus"></i> Tambah Data
    </button>
    <table class="mt-2 table table-bordered">
        <thead class="text-center">
            <th scope="col">No.</th>
            <th scope="col">Barang</th>
            <th scope="col">Supplier</th>
            <th colspan="2">Aksi</th>
        </thead>
        <tbody id="ans">

        </tbody>
    </table>
    </form>


    <!-- MODAL TAMBAH DATA -->
    <div class="modal fade" id="nilaiModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="nilaiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nilaiModal">Tambah Data Penilaian</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </div>
                <div class="modal-body">
                    <form action="config/crud.php" method="post">
                        <div class="form-group mt-2">
                            <label for="name">Alternatif</label>
                            <div class="input-control select full-size">
                                <select class="custom-select" name="id_alternatif">
                                    <option disabled selected>Pilih Supplier</option>
                                    <?php
                                    $query1 = "SELECT * FROM alternatif order by alternatif asc";
                                    $result1 = mysqli_query($koneksi, $query1);
                                    $no = 1;
                                    while ($row = $result1->fetch_array()) {
                                    ?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['alternatif']; ?></option>
                                    <?php                                                                                                }
                                    ?>
                                </select>
                            </div>
                            <label for="name" class="mt-2">Barang</label>
                            <div class="input-control select full-size">
                                <select class="custom-select" name="id_barang" id="id_barang">
                                    <option disabled selected>Pilih Barang</option>

                                    <?php
                                    $query1 = "SELECT * FROM barang ORDER BY barang asc";
                                    $result1 = mysqli_query($koneksi, $query1);
                                    while ($row2 = $result1->fetch_array()) {
                                    ?>
                                        <option value="<?php echo $row2['id'] ?>"><?php echo $row2['barang']; ?></option>
                                    <?php                                                                                                }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <label for="name"><b>Penilaian Kriteria</b></label>
                        <?php
                        $query2 = "SELECT * FROM kriteria";
                        $result2 = mysqli_query($koneksi, $query2);
                        $no = 1;
                        while ($row2 = $result2->fetch_array()) {
                        ?>
                            <div class="row cells3 mt-2 ml-4 mb-4">
                                <label class="cell"><input type="hidden" name="id_kriteria[<?php echo $row2['id'] ?>]" value="<?php echo $row2['id'] ?>"> &nbsp;
                                    <?php echo $no++ ?>.
                                    <?php echo $row2['nama'] ?></label>
                                <div class="cell colspan2">
                                    <div class="input-control">
                                        <select name="nilai[<?php echo $row2['id'] ?>]" class="custom-select ml-5">
                                            <option disabled selected>Pilih SubKriteria</option>

                                            <?php
                                            $stmt5 =  "SELECT * FROM subkriteria where id_kriteria='" . $row2['id'] . "'";
                                            $stmt5 = mysqli_query($koneksi, $stmt5);
                                            while ($row5 = $stmt5->fetch_array()) {
                                            ?>
                                                <option value="<?php echo $row5['nilai'] ?>"><?php echo $row5['subkriteria'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" name="tambahPenilaian" class="btn btn-primary">Tambah Data</a></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->
</div>
<link rel="stylesheet" type="text/css" href="assets/css/style.css">

<?php

include('template/footer.php');
?>