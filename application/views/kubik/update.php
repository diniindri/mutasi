<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Kubik</h1>
    </div>

    <form action="" method="post" autocomplete="off">

        <div class="row">
            <div class="col-lg-3">
                <div class="form-group mb-2">
                    <label for="">Golongan:</label>
                    <input type="text" name="gol" class="form-control <?= form_error('gol') ? 'is-invalid' : ''; ?>" value="<?= $kubik['gol']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('gol'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Status:</label>
                    <input type="text" name="sts" class="form-control <?= form_error('sts') ? 'is-invalid' : ''; ?>" value="<?= $kubik['sts']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('sts'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Jumlah Anggota:</label>
                    <input type="text" name="jml" class="form-control <?= form_error('jml') ? 'is-invalid' : ''; ?>" value="<?= $kubik['jml']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('jml'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Jumlah Kubik:</label>
                    <input type="text" name="jumlah" class="form-control <?= form_error('jumlah') ? 'is-invalid' : ''; ?>" value="<?= $kubik['jumlah']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('jumlah'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="<?= base_url('kubik'); ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>

    </form>

</main>