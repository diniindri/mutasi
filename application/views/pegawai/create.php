<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Pegawai</h1>
    </div>

    <form action="" method="post" autocomplete="off">

        <div class="row">
            <div class="col-lg-4">
                <div class="form-group mb-2">
                    <label for="">NIP:</label>
                    <input type="text" name="nip" class="form-control <?= form_error('nip') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('nip'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nama:</label>
                    <input type="text" name="nmpeg" class="form-control <?= form_error('nmpeg') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('nmpeg'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Kdgapok:</label>
                    <input type="text" name="kdgapok" class="form-control <?= form_error('kdgapok') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('kdgapok'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Kdkawin:</label>
                    <input type="text" name="kdkawin" class="form-control <?= form_error('kdkawin') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('kdkawin'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nomor Rekening:</label>
                    <input type="text" name="rekening" class="form-control <?= form_error('rekening') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('rekening'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nama Bank:</label>
                    <input type="text" name="nm_bank" class="form-control <?= form_error('nm_bank') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('nm_bank'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nama Rekening:</label>
                    <input type="text" name="nmrek" class="form-control <?= form_error('nmrek') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('nmrek'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="<?= base_url('pegawai/index/') . $sk_id; ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>

    </form>

</main>