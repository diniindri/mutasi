<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Pejabat</h1>
    </div>

    <!-- <form action="" method="post" autocomplete="off"> -->
    <?= form_open(); ?>

    <div class="row">
        <div class="col-lg-3">
            <div class="form-group mb-2">
                <label for="">Kode:</label>
                <input type="text" name="kode" class="form-control <?= form_error('kode') ? 'is-invalid' : ''; ?>" value="<?= $pejabat['kode']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('kode'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">NIP:</label>
                <input type="text" name="nip" class="form-control <?= form_error('nip') ? 'is-invalid' : ''; ?>" value="<?= $pejabat['nip']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('nip'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Nama:</label>
                <input type="text" name="nama" class="form-control <?= form_error('nama') ? 'is-invalid' : ''; ?>" value="<?= $pejabat['nama']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('nama'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Jabatan:</label>
                <input type="text" name="jabatan" class="form-control <?= form_error('jabatan') ? 'is-invalid' : ''; ?>" value="<?= $pejabat['jabatan']; ?>">
                <div class="invalid-feedback">
                    <?= form_error('jabatan'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <a href="<?= base_url('pejabat'); ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
            </div>
        </div>
    </div>

    </form>

</main>