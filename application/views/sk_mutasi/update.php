<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah SK Mutasi</h1>
    </div>

    <!-- <form action="" method="post" autocomplete="off"> -->
    <?= form_open(); ?>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group mb-2">
                <label for="">Nomor:</label>
                <input type="text" name="nomor" class="form-control <?= form_error('nomor') ? 'is-invalid' : ''; ?>" value="<?= $sk['nomor']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('nomor'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Tanggal:</label>
                <input type="text" name="tanggal" class="form-control <?= form_error('tanggal') ? 'is-invalid' : ''; ?>" placeholder="dd-mm-yyyy" value="<?= date('d-m-Y', $sk['tanggal']); ?>">
                <div class="invalid-feedback">
                    <?= form_error('tanggal'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Uraian:</label>
                <textarea name="uraian" cols="30" rows="5" class="form-control <?= form_error('uraian') ? 'is-invalid' : ''; ?>"><?= $sk['uraian']; ?></textarea>
                <div class="invalid-feedback">
                    <?= form_error('uraian'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Status:</label>
                <select class="form-select form-select-sm mb-3" name="status">
                    <option value="0" <?= $sk['status'] == 0 ? 'selected' : ''; ?>>Non Aktif</option>
                    <option value="1" <?= $sk['status'] == 1 ? 'selected' : ''; ?>>Aktif</option>
                </select>
            </div>
            <div class="form-group mb-2">
                <label for="">Nomor SPP:</label>
                <input type="text" name="nospp" class="form-control <?= form_error('nospp') ? 'is-invalid' : ''; ?>" value="<?= $sk['nospp']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('nospp'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Tanggal SPP:</label>
                <input type="text" name="tglspp" class="form-control <?= form_error('tglspp') ? 'is-invalid' : ''; ?>" placeholder="dd-mm-yyyy" value="<?= date('d-m-Y', $sk['tglspp']); ?>">
                <div class="invalid-feedback">
                    <?= form_error('tglspp'); ?>
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