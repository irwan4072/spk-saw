<?php

$conn = mysqli_connect('localhost', 'root', '', 'spk_saw');

function query($query)
{
    global $conn;
    return mysqli_query($conn, $query);
}
function hitung($data)
{
    $kriteriaInput = $data['kriteria'];
    $kriteriaDB = tampil("SELECT * FROM kriteria");
    $alternatif = tampil("SELECT * FROM alternatif");

    $jumlahBanyakKriteriaInput = count($kriteriaInput);
    foreach ($kriteriaDB as $kriteria) {

        $idK = $kriteria['id_kriteria'];

        foreach ($alternatif as $alt) {
            $idA = $alt['id'];
            $x = $kriteriaInput[$idA][$idK];



            if ($kriteria['jenis_kriteria'] == 'benefit') {
                // -------------benefit---------------
                $nilaiMax = 0;
                for ($i = 0; $i < $jumlahBanyakKriteriaInput; $i++) {
                    if ($nilaiMax < $kriteriaInput[$idA]) {
                        $nilaiMax = $kriteriaInput[$idA][$idK];
                    }
                }
            } else {
                //---------------cost--------------------
                $nilaiMin = 0;
                for ($i = 0; $i < $jumlahBanyakKriteriaInput; $i++) {
                    if ($nilaiMin < $kriteriaInput[$idA]) {
                        $nilaiMin = $kriteriaInput[$idA][$idK];
                    }
                }
            }
        }
    }
    // var_dump($nilaiMax);
    // die;

    foreach ($alternatif as $alt) {
        $idA = $alt['id'];

        foreach ($kriteriaDB as $kriteria) {
            $idK = $kriteria['id_kriteria'];

            if ($kriteria['jenis_kriteria'] == 'benefit') {
                // -------------benefit---------------

                // for ($i = 0; $i < count($kriteria); $i++) {
                $kriteriaSudahHitung[$idA][$idK] = $kriteriaInput[$idA][$idK] / $nilaiMax;
                // echo $kriteriaSudahHitung[$idA][$idK];
                // }
            } else {
                //---------------cost--------------------
                // for ($i = 0; $i < count($kriteria); $i++) {
                $kriteriaSudahHitung[$idA][$idK] = $nilaiMin / $kriteriaInput[$idA][$idK];
                // echo $kriteriaSudahHitung[$idA][$idK];
                // }
            }
        }
    }
    foreach ($alternatif as $alt) {
        $idA = $alt['id'];

        foreach ($kriteriaDB as $kriteria) {
            $idK = $kriteria['id_kriteria'];

            $kriteriaSudahPerkalian[$idA][$idK] = $kriteriaSudahHitung[$idA][$idK] * $kriteria['bobot'];
        }
    }
    foreach ($alternatif as $alt) {
        $idA = $alt['id'];

        foreach ($kriteriaDB as $kriteria) {
            $idK = $kriteria['id_kriteria'];
            $hasil = 0;
            for ($i = 0; $i < count($kriteria); $i++) {

                $result[$idA] = $hasil + $kriteriaSudahPerkalian[$idA][$idK];
            }
        }
    }
    $terbesar = 0;
    $terbaik = null;
    foreach ($alternatif as $alt) {
        $idA = $alt['id'];

        // for ($i = 0; $i < count($kriteria); $i++) {
        if ($terbesar < $result[$idA]) {
            $terbesar = $result[$idA];
            $terbaik = $alt['id'];
        }
        // }
    }

    $hasilAkhir = tampil("SELECT * FROM alternatif WHERE id = '$terbaik'");
    if ($hasilAkhir) {
        echo $hasilAkhir[0]['nama_alternatif'];
    }

    // var_dump($hasilAkhir);
    // var_dump($nilaiMin);
    die;
    return 'a';
}
function tampil($query)
{
    global $conn;

    $tampil = query($query);
    $data = [];
    while ($banyakdata = mysqli_fetch_assoc($tampil)) {
        $data[] = $banyakdata;
    }
    return $data;
}

function tambah_kriteria($data)
{
    global $conn;
    $id_kriteria = htmlspecialchars($data['id_kriteria']);
    $nama_kriteria = htmlspecialchars($data['nama_kriteria']);
    $jenis_kriteria = htmlspecialchars($data['jenis_kriteria']);
    $bobot = htmlspecialchars($data['bobot']);

    if (is_integer($id_kriteria)) {
        $query = "UPDATE kriteria SET 
        `id_kriteria` = '$id_kriteria',
        `nama_kriteria` = '$nama_kriteria',
        `jenis_kriteria` = '$jenis_kriteria',
        `bobot` = '$bobot'
        WHERE `id_kriteria` = '$id_kriteria'";
    } else {
        $query = "INSERT INTO `kriteria` (`id`, `nama_kriteria`, `jenis_kriteria`, `bobot`) VALUES ('','nama_kriteria','jenis_kriteria','bobot')";
    }
    $tambah = query($query);
    return mysqli_affected_rows($conn);
}
function tambah_alternatif($data)
{
    global $conn;
    $id = htmlspecialchars($data['id']);
    $nama_alternatif = htmlspecialchars($data['nama_alternatif']);
    $keterangan = htmlspecialchars($data['keterangan']);

    if (is_integer($id)) {
        $query = "UPDATE kriteria SET 
        `id` = '$id',
        `nama_alternatif` = '$nama_alternatif',
        `keterangan` = '$keterangan',
        WHERE `id` = '$id'";
    } else {
        $query = "INSERT INTO `kriteria` (`id`, `nama_alternatif`, `keterangan`) VALUES ('','nama_alternatif','keterangan')";
    }
    $tambah = query($query);
    return mysqli_affected_rows($conn);
}
