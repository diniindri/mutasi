<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Packing</h1>
    </div>

    <form action="" method="post" autocomplete="off">

        <div class="row">
            <div class="col-lg-3">
                <div class="form-group mb-2">
                    <label for="">Uraian :</label>
                    <input type="text" name="kota_asal" class="form-control <?= form_error('kota_asal') ? 'is-invalid' : ''; ?>" value="<?= $packing['kota_asal']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('kota_asal'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Jenis :</label>
                    <input type="text" name="kota_tujuan" class="form-control <?= form_error('kota_tujuan') ? 'is-invalid' : ''; ?>" value="<?= $packing['kota_tujuan']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('kota_tujuan'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Jumlah :</label>
                    <input type="text" name="jumlah" class="form-control <?= form_error('jumlah') ? 'is-invalid' : ''; ?>" value="<?= $packing['jumlah']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('jumlah'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="<?= base_url('packing'); ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>

    </form>

</main>