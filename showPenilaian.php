<?php
include('config/config.php');
$a = $_POST['id'];
$a = trim($a);
$sql = "SELECT Distinct alternatif.alternatif, barang.barang FROM penilaian JOIN barang, alternatif
WHERE penilaian.id_alternatif = alternatif.id AND penilaian.id_barang = barang.id AND barang.barang='{$a}'  ";
$res = mysqli_query($koneksi, $sql);
$i = 0;
while ($rows = mysqli_fetch_array($res)) {
    $i++; ?>


    <tr>
        <td class="text-center"><?php echo $i ?>.</td>
        <td><?php echo $rows['barang']; ?></td>
        <td><?php echo $rows['alternatif']; ?></td>
        <td scope="col" class="text-center">
            <!-- <input type="hidden" name="id_alternatif" id="id_alternatif" value="<?php echo $row['id_barang']; ?>"> -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal <?php echo $row['id_barang']; ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data Penilaian">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </button>
            <form action="config/crud.php" method="POST" class="d-inline">
                <input type="hidden" name="id_alternatif" id="id_alternatif" value="<?php echo $data['id']; ?>">
                <button type="submit" name="hapusDetailsupplier" value="<?= $row['id_altbrg']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah anda yakin ingin menghapus data  ini?')"><i class="fas fa-trash"></i> Delete</button>
            </form>
        </td>
    </tr>
    <!-- MODAL EDIT DATA -->
    <?php
    $query = "SELECT * FROM penilaian";
    $result = mysqli_query($koneksi, $query);
    $i = 0;
    while ($data = mysqli_fetch_array($result)) {
        $i++; ?>
        <div class="modal fade" id="editModal <?php echo $data['id_barang']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="nilaiModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal">Edit Data Penilaian</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form action="config/crud.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $data['id_barang']; ?>">
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
                                            <option value="<?php echo $row['id'] ?>" <?= $data['id_alternatif'] == $row['id']  ? 'selected' : null ?>><?= $row['alternatif'] ?></option>
                                        <?php                                                                                                }
                                        ?>
                                    </select>
                                </div>
                                <label for="name" class="mt-2">Barang</label>
                                <div class="input-control select full-size">
                                    <select class="custom-select" name="id_barang" id="id_barang">
                                        <option disabled selected>Pilih Barang</option>

                                        <?php
                                        $query2 = "SELECT * FROM barang ORDER BY barang asc";
                                        $result2 = mysqli_query($koneksi, $query2);
                                        while ($row2 = $result2->fetch_array()) {
                                        ?>
                                            <option value="<?php echo $row2['id'] ?>" <?= $data['id_barang'] == $row2['id']  ? 'selected' : null ?>><?php echo $row2['barang'] ?></option>
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
                                                    <option value="<?php echo $row5['nilai'] ?>" <?= $data['nilai'] == $row5['nilai']  ? 'selected' : null ?>><?php echo $row5['subkriteria'] ?></option>
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
    <?php
    }
    ?>
    <!-- END MODAL -->
<?php }
echo $sql;
?>