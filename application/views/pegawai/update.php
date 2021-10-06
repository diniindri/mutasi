<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Pegawai</h1>
    </div>

    <form action="" method="post" autocomplete="off">

        <div class="row">
            <div class="col-lg-3">
                <div class="form-group mb-2">
                    <label for="">NIP:</label>
                    <input type="text" name="nip" class="form-control <?= form_error('nip') ? 'is-invalid' : ''; ?>" value="<?= $pegawai['nip']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('nip'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nama:</label>
                    <input type="text" name="nmpeg" class="form-control <?= form_error('nmpeg') ? 'is-invalid' : ''; ?>" value="<?= $pegawai['nmpeg']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('nmpeg'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Kdgapok:</label>
                    <input type="text" name="kdgapok" class="form-control <?= form_error('kdgapok') ? 'is-invalid' : ''; ?>" value="<?= $pegawai['kdgapok']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('kdgapok'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">tingkat:</label>
                    <input type="text" name="kdkawin" class="form-control <?= form_error('kdkawin') ? 'is-invalid' : ''; ?>" value="<?= $pegawai['kdkawin']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('kdkawin'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nomor Rekening:</label>
                    <input type="text" name="rekening" class="form-control <?= form_error('rekening') ? 'is-invalid' : ''; ?>" value="<?= $pegawai['rekening']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('rekening'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nama Bank:</label>
                    <input type="text" name="nm_bank" class="form-control <?= form_error('nm_bank') ? 'is-invalid' : ''; ?>" value="<?= $pegawai['nm_bank']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('nm_bank'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nama Rekening:</label>
                    <input type="text" name="nmrek" class="form-control <?= form_error('nmrek') ? 'is-invalid' : ''; ?>" value="<?= $pegawai['nmrek']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('nmrek'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group mb-2">
                    <label for="">Infant:</label>
                    <input type="text" name="infant" class="form-control <?= form_error('infant') ? 'is-invalid' : ''; ?>" value="<?= $pegawai['infant']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('infant'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">ART:</label>
                    <input type="text" name="art" class="form-control <?= form_error('art') ? 'is-invalid' : ''; ?>" value="<?= $pegawai['art']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('art'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nomor SPD:</label>
                    <input type="text" name="no_spd" class="form-control <?= form_error('no_spd') ? 'is-invalid' : ''; ?>" value="<?= $pegawai['no_spd']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('no_spd'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Tanggal SPD:</label>
                    <input type="text" name="tgl_spd" class="form-control <?= form_error('tgl_spd') ? 'is-invalid' : ''; ?>" placeholder="dd-mm-yyyy" value="<?= $pegawai['tgl_spd'] == '' ? '' : date('d-m-Y', $pegawai['tgl_spd']); ?>">
                    <div class="invalid-feedback">
                        <?= form_error('tgl_spd'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Jabatan:</label>
                    <input type="text" name="jabatan" class="form-control <?= form_error('jabatan') ? 'is-invalid' : ''; ?>" value="<?= $pegawai['jabatan']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('jabatan'); ?>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Tingkat Biaya:</label>
                    <input type="text" name="tingkat" class="form-control <?= form_error('tingkat') ? 'is-invalid' : ''; ?>" value="<?= $pegawai['tingkat']; ?>">
                    <div class="invalid-feedback">
                        <?= form_error('tingkat'); ?>
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