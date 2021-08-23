<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Keluarga</h1>
    </div>

    <form action="" method="post" autocomplete="off">

        <div class="row">
            <div class="col-lg-4">
                <div class="form-group mb-2">
                    <label for="">Nama:</label>
                    <input type="text" name="nama" class="form-control <?= form_error('nama') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('nama'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Status Keluarga:</label>
                    <select class="form-select form-select-sm mb-3" name="kdkeluarga">
                        <?php foreach ($status_keluarga as $r) : ?>
                            <option value="<?= $r['id']; ?>"><?= $r['nama']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="">Tanggal Lahir:</label>
                    <input type="text" name="tgllhr" class="form-control <?= form_error('tgllhr') ? 'is-invalid' : ''; ?>" placeholder="yyyy-mm-dd">
                    <div class="invalid-feedback">
                        <?= form_error('tgllhr'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Status Tunjangan:</label>
                    <select class="form-select form-select-sm mb-3" name="kddapat">
                        <option value="1">Dapat</option>
                        <option value="2">Tidak</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="">Status Usia:</label>
                    <select class="form-select form-select-sm mb-3" name="sts">
                        <option value="0">Dewasa</option>
                        <option value="1">Infant</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="<?= base_url('keluarga/index/') . $pegawai_id . '/' . $sk_id; ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>

    </form>

</main>