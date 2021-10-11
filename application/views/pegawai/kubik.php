<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Kubik</h1>
    </div>

    <!-- <form action="" method="post" autocomplete="off"> -->
    <?= form_open(); ?>

    <div class="row">
        <div class="col-lg-3">
            <div class="form-group mb-2">
                <label for="">Kdgapok:</label>
                <input type="text" name="kdgapok" class="form-control <?= form_error('kdgapok') ? 'is-invalid' : ''; ?>" value="<?= $pegawai['kdgapok']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('kdgapok'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Kdkawin:</label>
                <input type="text" name="kdkawin" class="form-control <?= form_error('kdkawin') ? 'is-invalid' : ''; ?>" value="<?= $pegawai['kdkawin']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('kdkawin'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Jumlah Kubik:</label>
                <input type="text" name="kubik" class="form-control <?= form_error('kubik') ? 'is-invalid' : ''; ?>" value="<?= $kubik; ?>">
                <div class="invalid-feedback">
                    <?= form_error('kubik'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <a href="<?= base_url('pegawai/index/') . $sk_id; ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
            </div>
        </div>
    </div>

    </form>

</main>