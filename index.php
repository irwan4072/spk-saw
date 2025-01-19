<?php include "template/header.php" ?>
<?php
$allKriteria = tampil("SELECT * FROM kriteria");
$allAlternatif = tampil("SELECT * FROM alternatif");


?>
<div class="text-center mt-3">
    <h2>hitung sesuatu yang terbaik</h2>
    <div class="container">
        <form action="" method="post">
            <div class="mb-3 row">
                <label for="kriteria" class="col-sm-2 col-form-label">Kriteria</label>
                <div class="col-sm-10">

                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>


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
                                    <td> <input class="form-control" type="number" placeholder="<?= $kriteria['nama_kriteria']; ?>" aria-label="default input example" id="kriteria" name="kriteria[]" aria-describedby="basic-addon2">
                                    </td>
                                <?php endforeach ?>

                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary">Primary</button>
            </div>
        </form>
    </div>



</div>
<?php include "template/footer.php" ?>