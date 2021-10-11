<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Uang Harian</h1>
    </div>

    <!-- <form action="" method="post" autocomplete="off"> -->
    <?= form_open(); ?>

    <div class="row">
        <div class="col-lg-3">
            <div class="form-group mb-2">
                <label for="">Provinsi:</label>
                <input type="text" name="provinsi" class="form-control <?= form_error('provinsi') ? 'is-invalid' : ''; ?>" value="<?= $uang_harian['provinsi']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('provinsi'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Luar Kota:</label>
                <input type="text" name="luar_kota" class="form-control <?= form_error('luar_kota') ? 'is-invalid' : ''; ?>" value="<?= $uang_harian['luar_kota']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('luar_kota'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Dalam Kota:</label>
                <input type="text" name="dalam_kota" class="form-control <?= form_error('dalam_kota') ? 'is-invalid' : ''; ?>" value="<?= $uang_harian['dalam_kota']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('dalam_kota'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Diklat:</label>
                <input type="text" name="diklat" class="form-control <?= form_error('diklat') ? 'is-invalid' : ''; ?>" value="<?= $uang_harian['diklat']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('diklat'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <a href="<?= base_url('uang_harian'); ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
            </div>
        </div>
    </div>

    </form>

</main>