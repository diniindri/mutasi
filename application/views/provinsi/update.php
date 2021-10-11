<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Provinsi</h1>
    </div>

    <!-- <form action="" method="post" autocomplete="off"> -->
    <?= form_open(); ?>

    <div class="row">
        <div class="col-lg-3">
            <div class="form-group mb-2">
                <label for="">Kota Tujuan:</label>
                <input type="text" name="tujuan" class="form-control <?= form_error('tujuan') ? 'is-invalid' : ''; ?>" value="<?= $provinsi['tujuan']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('tujuan'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Provinsi:</label>
                <input type="text" name="provinsi" class="form-control <?= form_error('provinsi') ? 'is-invalid' : ''; ?>" value="<?= $provinsi['provinsi']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('provinsi'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <a href="<?= base_url('provinsi'); ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
            </div>
        </div>
    </div>

    </form>

</main>