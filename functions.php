<?php

$conn = mysqli_connect('localhost', 'root', '', 'spk_saw');

function query($query)
{
    global $conn;
    return mysqli_query($conn, $query);
}
function hitung()
{
    $kriteria = $_post['kriteria'];
    $alternatif = $_POST['alternatif'];
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
