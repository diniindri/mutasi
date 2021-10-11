<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah User </h1>
    </div>

    <!-- <form action="" method="post" autocomplete="off"> -->
    <?= form_open(); ?>

    <div class="row">
        <div class="col-lg-3">
            <div class="form-group mb-2">
                <label for="">Nama:</label>
                <input type="text" name="nama" class="form-control <?= form_error('nama') ? 'is-invalid' : ''; ?>">
                <div class="invalid-feedback">
                    <?= form_error('nama'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">NIP:</label>
                <input type="text" name="nip" class="form-control <?= form_error('nip') ? 'is-invalid' : ''; ?>">
                <div class="invalid-feedback">
                    <?= form_error('nip'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Email:</label>
                <input type="email" name="email" class="form-control <?= form_error('email') ? 'is-invalid' : ''; ?>">
                <div class="invalid-feedback">
                    <?= form_error('email'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Password:</label>
                <input type="password" name="password" class="form-control <?= form_error('password') ? 'is-invalid' : ''; ?>">
                <div class="invalid-feedback">
                    <?= form_error('password'); ?>
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Status:</label>
                <input type="text" name="is_active" class="form-control <?= form_error('is_active') ? 'is-invalid' : ''; ?>">
                <div class="invalid-feedback">
                    <?= form_error('is_active'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <a href="<?= base_url('users'); ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
            </div>
        </div>
    </div>

    </form>

</main>