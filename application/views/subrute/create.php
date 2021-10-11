<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Sub Rute</h1>
    </div>

    <!-- <form action="" method="post" autocomplete="off"> -->
    <?= form_open(); ?>

    <div class="row">
        <div class="col-lg-3">
            <div class="form-group mb-2">
                <label for="">Jenis Rute:</label>
                <select class="form-select form-select-sm mb-3" name="jenis_id">
                    <?php foreach ($jenis_rute as $r) :  ?>
                        <option value="<?= $r['id']; ?>"><?= $r['nama']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-2">
                <label for="">Jenis Angkutan:</label>
                <select class="form-select form-select-sm mb-3" name="angkutan_id">
                    <?php foreach ($jenis_angkutan as $r) :  ?>
                        <option value="<?= $r['id']; ?>"><?= $r['nama']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <a href="<?= base_url('subrute/index/') . $rute_id; ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
            </div>
        </div>
    </div>

    </form>

</main>