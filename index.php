<?php
session_start();
include('config/config.php');
include('page_layout.php');

if (!isset($_SESSION["login"])) {
    echo  "<script>
    alert('Silahkan Login Terlebih Dahulu!');
    document.location.href = 'config/login.php';</script>";
    exit;
}
?>
<ol class="breadcrumb py-4">
    <li class="breadcrumb-item active" aria-current="page">Home</li>
</ol>

</div>
<div class="container-fluid">
    <h1 class="mt-4">HOME</h1>
    <div class="card">
        <div class="card-body">
            Selamat datang admin pada Sistem Pendukung Keputusan (SPK) Pemilihan Supplier
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Daftar Supplier</h2>
                    <p class="card-text">Daftar Supplier yang bekerja sama dengan Apotek Grajakan</p>
                    <a href="supplier.php" class="btn btn-primary">Daftar Supplier</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Daftar Kriteria</h2>
                    <p class="card-text">Daftar Kriteria yang menjadi acuan dalam memilih supplier </p>
                    <a href="kriteria.php" class="btn btn-primary">Daftar Kriteria</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Sub Kriteria</h2>
                    <p class="card-text">Sub kriteria yang dijadikan acuan dalam menilai alternatif</p>
                    <a href="subkriteria.php" class="btn btn-primary">Sub Kriteria</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Daftar Barang</h2>
                    <p class="card-text">Daftar barang yang dimiliki apotek</p>
                    <a href="barang.php" class="btn btn-primary">Daftar Barang</a>
                </div>
            </div>
        </div>

    </div>
    <div class="row mt-3">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Bobot Kriteria</h2>
                    <p class="card-text">Bobot nilai yang diberikan untuk setiap kriteria</p>
                    <a href="bobotkriteria.php" class="btn btn-primary">Bobot Kriteria</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Penilaian</h2>
                    <p class="card-text">Penilaian berdasarkan perhitungan dengan menggunakan metode AHP-SMART</p>
                    <a href="penilaian.php" class="btn btn-primary">Penilaian</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="card mt-3 mb-5 mx-auto" style="width: 25rem;">
            <div class="card-body">
                <h2 class="card-title">Hasil Akhir</h2>
                <p class="card-text">Hasil akhir berdasarkan perhitungan dengan menggunakan metode AHP-SMART</p>
                <a href="hasil.php" class="btn btn-primary">Hasil Akhir</a>
            </div>
        </div>
    </div>
</div>
<?php
include('template/footer.php')
?>