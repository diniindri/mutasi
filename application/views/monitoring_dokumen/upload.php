<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Upload Dokumen</h1>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?php if ($this->session->flashdata('pesan')) : ?>
                <?= $this->session->flashdata('pesan'); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= form_open_multipart(); ?>
            <div class="mb-3">
                <label for="" class="form-label">Pilih Jenis Dokumen : </label>
                <select class="form-select form-select-sm" aria-label="" name="kode">
                    <?php foreach ($dokumen as $r) : ?>
                        <option value="<?= $r['kode']; ?>"><?= $r['jenis']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Upload file dengan format pdf maksimal 10 MB</label>
                <input class="form-control form-control-sm <?= form_error('file') ? 'is-invalid' : '' ?>" type="file" name="file" required>
                <div class="invalid-feedback">
                    <?= form_error('file') ?>
                </div>
            </div>
            <a href="<?= base_url('monitoring-dokumen/detail/') . $sk_id; ?>" class="btn btn-sm btn-outline-secondary mr-1">Batal</a>
            <button type="submit" class="btn btn-sm btn-outline-secondary">Upload</button>
            </form>
        </div>
    </div>
</main>