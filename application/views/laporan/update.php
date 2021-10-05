<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Laporan</h1>
    </div>

    <form action="" method="post" autocomplete="off">

        <div class="row">
            <div class="col-lg-3">
                <div class="form-group mb-2">
                    <label for="">Tahun Anggaran:</label>
                    <input type="text" name="tahun_anggaran" class="form-control <?= form_error('tahun_anggaran') ? 'is-invalid' : ''; ?>" value="<?= $laporan['tahun_anggaran']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('tahun_anggaran'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nomor SPD:</label>
                    <input type="text" name="nomor_spd" class="form-control <?= form_error('nomor_spd') ? 'is-invalid' : ''; ?>" value="<?= $laporan['nomor_spd']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('nomor_spd'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Akun:</label>
                    <input type="text" name="akun" class="form-control <?= form_error('akun') ? 'is-invalid' : ''; ?>" value="<?= $laporan['akun']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('akun'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">DIPA Kantor:</label>
                    <input type="text" name="dipa_kantor" class="form-control <?= form_error('dipa_kantor') ? 'is-invalid' : ''; ?>" value="<?= $laporan['dipa_kantor']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('dipa_kantor'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="<?= base_url('laporan'); ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>

    </form>

</main>