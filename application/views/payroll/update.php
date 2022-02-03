<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Daftar Payroll</h1>
    </div>

    <!-- <form action="" method="post" autocomplete="off"> -->
    <?= form_open(); ?>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group mb-2">
                <label for="">Uraian:</label>
                <input type="text" name="uraian" class="form-control <?= form_error('uraian') ? 'is-invalid' : ''; ?>" value="<?= $payroll['uraian']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('uraian'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Tanggal:</label>
                <input type="text" name="tanggal" class="form-control <?= form_error('tanggal') ? 'is-invalid' : ''; ?>" placeholder="dd-mm-yyyy" value="<?= date('d-m-Y', $payroll['tanggal']); ?>">
                <div class="invalid-feedback">
                    <?= form_error('tanggal'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Nomor SPP:</label>
                <input type="text" name="nospp" class="form-control <?= form_error('nospp') ? 'is-invalid' : ''; ?>" value="<?= $payroll['nospp']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('nospp'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Tanggal SPP:</label>
                <input type="text" name="tglspp" class="form-control <?= form_error('tglspp') ? 'is-invalid' : ''; ?>" placeholder="dd-mm-yyyy" value="<?= date('d-m-Y', $payroll['tglspp']); ?>">
                <div class="invalid-feedback">
                    <?= form_error('tglspp'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <a href="<?= base_url('payroll/detail/') . $sk_id . 'a/'; ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
            </div>
        </div>
    </div>

    </form>

</main>