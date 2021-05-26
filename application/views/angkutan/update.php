<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Angkutan</h1>
    </div>

    <form action="" method="post" autocomplete="off">

        <div class="row">
            <div class="col-lg-3">
                <div class="form-group mb-2">
                    <label for="">Nama:</label>
                    <input type="text" name="nama" class="form-control <?= form_error('nama') ? 'is-invalid' : ''; ?>" value="<?= $angkutan['nama']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('nama'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Icon:</label>
                    <input type="text" name="icon" class="form-control <?= form_error('icon') ? 'is-invalid' : ''; ?>" value="<?= $angkutan['icon']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('icon'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Jenis:</label>
                    <input type="text" name="jenis_id" class="form-control <?= form_error('jenis_id') ? 'is-invalid' : ''; ?>" value="<?= $angkutan['jenis_id']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('jenis_id'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="<?= base_url('angkutan'); ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>

    </form>

</main>