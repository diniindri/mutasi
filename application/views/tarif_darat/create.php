<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Tarif Darat</h1>
    </div>

    <form action="" method="post" autocomplete="off">

        <div class="row">
            <div class="col-lg-3">
                <div class="form-group mb-2">
                    <label for="">Orang:</label>
                    <input type="text" name="orang" class="form-control <?= form_error('orang') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('orang'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Barang:</label>
                    <input type="text" name="barang" class="form-control <?= form_error('barang') ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('barang'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="<?= base_url('tarif_darat'); ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>

    </form>

</main>