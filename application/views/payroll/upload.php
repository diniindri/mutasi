<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Upload Tagihan</h1>
    </div>

    <form action="" method="post" autocomplete="off">

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group mb-2">
                    <label for="">Jenis Dokumen:</label>
                    <select class="form-select form-select-sm mb-3" name="jenis tagihan">
                        <option value="0">SPP/SPBy</option>
                        <option value="1">lampiran SPP/SPBy</option>
                        <option value="0">SPM</option>
                        <option value="0">Lampiran SPM</option>
                        <option value="0">Bukti payroll</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="">Keterangan Dokumen:</label>
                    <input type="text" name="nmpeg" class="form-control <?= form_error('nmpeg') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('nmpeg'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Pilih File:</label>
                    <input type="text" name="nmpeg" class="form-control <?= form_error('nmpeg') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('nmpeg'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="<?= base_url('sk-mutasi'); ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>

    </form>

</main>