<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Daftar Payroll</h1>
    </div>

    <form action="" method="post" autocomplete="off">

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
                    <label for="">Jumlah:</label>
                    <input type="text" name="jumlah" class="form-control <?= form_error('jumlah') ? 'is-invalid' : ''; ?>" value="<?= $payroll['jumlah']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('jumlah'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nominal:</label>
                    <input type="text" name="nominal" class="form-control <?= form_error('nominal') ? 'is-invalid' : ''; ?>" value="<?= $payroll['nominal']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('nominal'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="<?= base_url('payroll/detail/') . $sk_id; ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>

    </form>

</main>