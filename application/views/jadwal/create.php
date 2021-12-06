<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Jadwal</h1>
    </div>
    <!-- <form action="" method="post" autocomplete="off"> -->
    <?= form_open(); ?>

    <div class="row">
        <div class="col-lg-4">
            <div class="form-group mb-2">
                <label for="">Uraian:</label>
                <input type="text" name="uraian" class="form-control <?= form_error('uraian') ? 'is-invalid' : ''; ?>">
                <div class="invalid-feedback">
                    <?= form_error('uraian'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">PIC:</label>
                <input type="text" name="pic" class="form-control <?= form_error('pic') ? 'is-invalid' : ''; ?>">
                <div class="invalid-feedback">
                    <?= form_error('pic'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Tanggal Awal:</label>
                <input type="text" name="tglawal" class="form-control <?= form_error('tglawal') ? 'is-invalid' : ''; ?>">
                <div class="invalid-feedback">
                    <?= form_error('tglawal'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Tanggal Akhir:</label>
                <input type="text" name="tglakhir" class="form-control <?= form_error('tglakhir') ? 'is-invalid' : ''; ?>">
                <div class="invalid-feedback">
                    <?= form_error('tglakhir'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <a href="<?= base_url('jadwal/detail/') . $sk_id; ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
            </div>
        </div>
    </div>

    </form>

</main>