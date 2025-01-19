<?php include "template/header.php";

if (isset($_POST['submit'])) {
    $hitung = hitung($_POST);
    var_dump($hitung);
}

// die;


?>
<?php
$allKriteria = tampil("SELECT * FROM kriteria");
$allAlternatif = tampil("SELECT * FROM alternatif");


?>
<div class="text-center mt-3">
    <h2>hitung sesuatu yang terbaik</h2>
    <div class="container">
        <form action="" method="post">


            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th></th>
                            <?php foreach ($allKriteria as $kriteria): ?>


                                <?php if ($kriteria['jenis_kriteria'] == 'benefit'): ?>
                                    <th><?= $kriteria['nama_kriteria']; ?></th>
                                <?php else : ?>
                                    <th><?= $kriteria['nama_kriteria']; ?> (cost)</th>
                                <?php endif ?>
                            <?php endforeach ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allAlternatif as $alternatif): ?>

                            <tr>
                                <td><?= $alternatif['nama_alternatif']; ?></td>
                                <?php foreach ($allKriteria as $kriteria): ?>
                                    <td> <input class="form-control" type="number" placeholder="<?= $kriteria['nama_kriteria']; ?>" aria-label="default input example" id="kriteria" name="kriteria[<?= $alternatif['id']; ?>][<?= $kriteria['id_kriteria']; ?>]" aria-describedby="basic-addon2">
                                    </td>
                                <?php endforeach ?>

                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <button type="submit" name="submit" class="btn btn-primary">Tentukan</button>
            </div>
        </form>
    </div>



</div>
<?php include "template/footer.php" ?>