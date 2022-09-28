<?php
include('config/config.php');
?>
<div class="col">
    <div class="card-header text-center">
        <h3>Tabel Penilaian Supplier Berdasarkan Kriteria dan Barang</h3>
    </div>
    <table class="mt-2 table table-bordered">
        <thead class="text-center">
            <tr>

                <th>No.</th>
                <th>Supplier</th>
                <?php
                $query4 = "SELECT * FROM kriteria";
                $result4 = mysqli_query($koneksi, $query4);
                $collectCriteria = [];
                $cMin = [];
                $cMax = [];
                while ($row4 = $result4->fetch_array()) {
                ?>
                    <th><?php echo $row4['nama'] ?></th>
                <?php
                    $collectCriteria[$row4['nama']] = [];
                    $cMax[$row4['nama']] = 0;
                    $cMin[$row4['nama']] = 0;
                }
                ?>
            </tr>
        </thead>

        <tbody>
            <?php
            $a = $_POST['id'];
            $sql = "SELECT Distinct alternatif.id, alternatif.alternatif, barang.barang FROM penilaian JOIN barang, alternatif WHERE penilaian.id_alternatif = alternatif.id AND penilaian.id_barang = barang.id AND barang.barang='$a'  ";
            $res = mysqli_query($koneksi, $sql);
            $i = 0;
            $collectNilai = [];
            while ($rows = mysqli_fetch_array($res)) {
                $i++;
            ?>
                <tr>

                    <td class="text-center"><?php echo $i ?>.</td>
                    <td><?php echo $rows['alternatif']; ?></td>
                    <?php
                    $id_alternatif = $rows['id'];
                    $query5 = "SELECT alternatif.alternatif, barang.barang, penilaian.nilai, kriteria.nama 
                    FROM penilaian JOIN barang, alternatif, kriteria 
                    WHERE penilaian.id_alternatif = alternatif.id 
                    AND penilaian.id_kriteria = kriteria.id 
                    AND penilaian.id_barang = barang.id 
                    AND barang.barang = '$a' 
                    AND alternatif.id = '$id_alternatif'";
                    $result5 = mysqli_query($koneksi, $query5);
                    while ($col = mysqli_fetch_array($result5)) {
                    ?>
                        <td class="text-center">
                            <?php echo $col['nilai']; ?>
                            <?php array_push($collectNilai, $col); ?>
                        </td>

                    <?php    } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="card-header text-center">
        <h3>Matriks Nilai Utiliti</h3>
    </div>
    <?php
    $no = 1;
    foreach ($collectNilai as $row) :
        array_push($collectCriteria[$row['nama']], $row['nilai']);
        $cMax[$row['nama']] = max($collectCriteria[$row['nama']]);
        $cMin[$row['nama']] = min($collectCriteria[$row['nama']]);
    ?>
    <?php $no++;
    endforeach; ?>
    <table class="mt-2 table table-bordered">
        <thead class="text-center">
            <tr>

                <th>No.</th>
                <th>Supplier</th>
                <?php
                $query6 = "SELECT * FROM kriteria";
                $result6 = mysqli_query($koneksi, $query6);
                while ($row6 = mysqli_fetch_array($result6)) {
                ?>
                    <th><?php echo $row6['nama'] ?></th>
                <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $a = $_POST['id'];
            $query7 = "SELECT Distinct alternatif.id, alternatif.alternatif, barang.barang FROM penilaian JOIN barang, alternatif 
            WHERE penilaian.id_alternatif = alternatif.id 
            AND penilaian.id_barang = barang.id AND barang.barang='{$a}'  ";
            $result7 = mysqli_query($koneksi, $query7);
            $i = 0;
            $collectNilaiUtility = [];
            while ($rows = mysqli_fetch_array($result7)) {
                $i++;
            ?>
                <tr>
                    <td class="text-center"><?php echo $i ?>.</td>
                    <td><?php echo $rows['alternatif']; ?></td>
                    <?php
                    $id_alternatif = $rows['id'];
                    $query8 = "SELECT alternatif.alternatif, barang.barang, penilaian.nilai, kriteria.nama, kriteria.sifat 
                    FROM penilaian JOIN barang, alternatif, kriteria 
                    WHERE penilaian.id_alternatif = alternatif.id
                     AND penilaian.id_kriteria = kriteria.id 
                    AND penilaian.id_barang = barang.id
                     AND barang.barang='$a'
                      AND alternatif.id = '$id_alternatif'";
                    $result8 = mysqli_query($koneksi, $query8);
                    while ($col = mysqli_fetch_array($result8)) {
                    ?>
                        <td class="text-center">
                            <?php
                            $hasil = 0;
                            $penyebut = ($cMax[$col['nama']] - $cMin[$col['nama']]);

                            if ($col['sifat'] === 'Benefit') {

                                if ($penyebut == 0) {
                                    $hasil = 0;
                                } else {
                                    $hasil = ($col['nilai'] - $cMin[$col['nama']]) / $penyebut;
                                }
                            } elseif ($col['sifat'] === 'Cost') {

                                if ($penyebut == 0) {
                                    $hasil = 0;
                                } else {
                                    $hasil = ($cMax[$col['nama']] - $col['nilai']) / $penyebut;
                                }
                            }

                            echo $hasil;
                            array_push($collectNilaiUtility, $hasil);
                            ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="card-header text-center">
        <h3>Matriks Penilaian Akhir</h3>
    </div>
    <table class="mt-2 table table-bordered">
        <thead class="text-center">
            <tr>

                <th>No.</th>
                <th>Supplier</th>
                <?php
                $query9 = "SELECT * FROM kriteria";
                $result9 = mysqli_query($koneksi, $query9);
                while ($row9 = mysqli_fetch_array($result9)) {
                ?>
                    <th><?php echo $row9['nama'] ?></th>
                <?php
                }
                ?>
                <th>Hasil</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $a = $_POST['id'];

            $query10 = "SELECT Distinct alternatif.id, alternatif.alternatif, barang.barang FROM penilaian JOIN barang, alternatif WHERE penilaian.id_alternatif = alternatif.id AND penilaian.id_barang = barang.id AND barang.barang='{$a}'  ";
            $result10 = mysqli_query($koneksi, $query10);
            $i = 0;
            $collectAlternatif = [];
            while ($rows = mysqli_fetch_array($result10)) {
                $i++;
            ?>
                <tr>

                    <td class="text-center"><?php echo $i ?>.</td>
                    <td><?php echo $rows['alternatif']; ?></td>
                    <?php
                    $id_alternatif = $rows['id'];
                    $collectAlternatif[$rows['alternatif']] = [];
                    $ranking = [];

                    $query11 = "SELECT alternatif.alternatif, barang.barang, penilaian.nilai, kriteria.nama, kriteria.sifat, bobot_kriteria.nilai as bobotkriteria 
                    FROM penilaian JOIN barang, kriteria, alternatif, bobot_kriteria WHERE penilaian.id_alternatif = alternatif.id 
                    AND penilaian.id_kriteria = kriteria.id 
                    AND penilaian.id_barang = barang.id 
                    AND bobot_kriteria.id_kriteria = kriteria.id
                    AND barang.barang = '$a'
                    AND alternatif.id = '$id_alternatif'";



                    $result11 = mysqli_query($koneksi, $query11);
                    while ($col = mysqli_fetch_array($result11)) {
                        $jumlah =  array_sum($collectAlternatif[$rows['alternatif']]);

                    ?>

                        <td>
                            <?php
                            $hasil = 0;
                            $penyebut = ($cMax[$col['nama']] - $cMin[$col['nama']]);

                            if ($col['sifat'] === 'Benefit') {

                                if ($penyebut == 0) {
                                    $hasil = 0;
                                } else {
                                    $hasil = ($col['nilai'] - $cMin[$col['nama']]) / $penyebut;
                                }
                            } elseif ($col['sifat'] === 'Cost') {

                                if ($penyebut == 0) {
                                    $hasil = 0;
                                } else {
                                    $hasil = ($cMax[$col['nama']] - $col['nilai']) / $penyebut;
                                }
                            }
                            $hasilAkhir = $col['bobotkriteria'] * $hasil;
                            echo $hasilAkhir;
                            array_push($collectAlternatif[$rows['alternatif']], $hasilAkhir);
                            array_push($ranking, $jumlah);

                            ?>
                        </td>
                    <?php } ?>
                    <td><?php echo $jumlah; ?> </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="card-header text-center">
        <h3>Ranking Supplier</h3>
    </div>
    <table class="mt-2 table table-bordered">
        <thead class="text-center">
            <tr>
                <th>Supplier</th>
                <th>Hasil</th>
                <th>Ranking</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $a = $_POST['id'];
            $query12 = "SELECT Distinct alternatif.id, alternatif.alternatif, barang.barang FROM penilaian JOIN barang, alternatif WHERE penilaian.id_alternatif = alternatif.id AND penilaian.id_barang = barang.id AND barang.barang='{$a}'  ";
            $result12 = mysqli_query($koneksi, $query12);
            $i = 0;
            $collectAlternatif = [];
            while ($rows = mysqli_fetch_array($result12)) {
                $i++;
            ?>
                <tr class="text-center">
                    <td><?php echo $rows['alternatif']; ?></td>
                    <?php
                    $id_alternatif = $rows['id'];
                    $collectAlternatif[$rows['alternatif']] = [];
                    $query13 = "SELECT alternatif.alternatif, barang.barang, penilaian.nilai, kriteria.nama, kriteria.sifat, bobot_kriteria.nilai as bobotkriteria 
                    FROM penilaian JOIN barang, kriteria, alternatif, bobot_kriteria WHERE penilaian.id_alternatif = alternatif.id 
                    AND penilaian.id_kriteria = kriteria.id 
                    AND penilaian.id_barang = barang.id 
                    AND bobot_kriteria.id_kriteria = kriteria.id
                    AND barang.barang = '$a'
                    AND alternatif.id = '$id_alternatif'";
                    $rankPerAlternatif = [];
                    $result13 = mysqli_query($koneksi, $query13);
                    while ($col = mysqli_fetch_array($result13)) {
                    ?>
                        <?php
                        $hasil = 0;
                        $penyebut = ($cMax[$col['nama']] - $cMin[$col['nama']]);

                        if ($col['sifat'] === 'Benefit') {

                            if ($penyebut == 0) {
                                $hasil = 0;
                            } else {
                                $hasil = ($col['nilai'] - $cMin[$col['nama']]) / $penyebut;
                            }
                        } elseif ($col['sifat'] === 'Cost') {

                            if ($penyebut == 0) {
                                $hasil = 0;
                            } else {
                                $hasil = ($cMax[$col['nama']] - $col['nilai']) / $penyebut;
                            }
                        }
                        $hasilAkhir = $col['bobotkriteria'] * $hasil;
                        array_push($collectAlternatif[$rows['alternatif']], $hasilAkhir);
                        $jumlah =  array_sum($collectAlternatif[$rows['alternatif']]);
                        array_push($rankPerAlternatif, $jumlah);
                        rsort($rankPerAlternatif);

                        ?>
                    <?php } ?>
                    <td><?php echo $jumlah; ?></td>
                    <td><?php echo $rankPerAlternatif;
                        var_dump($rankPerAlternatif); ?></td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>