<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tarik Data Pegawai Dari HRIS</h1>
    </div>
    <div class="row">
        <div class="col">
            <?php if ($this->session->flashdata('pesan')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Selamat!</strong> <?= $this->session->flashdata('pesan'); ?>
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            <a href="<?= base_url('pegawai/index/') . $sk_id . '/a'; ?>" class="btn btn-sm btn-outline-secondary mt-1 mb-1"> Sebelumnya</a>
        </div>
        <div class="col-lg-5">
            <!-- <form action="" method="post" autocomplete="off"> -->
            <?= form_open(); ?>
            <div class="input-group">
                <input type="text" name="nip" class="form-control" placeholder="nip pegawai">
                <button class="btn btn-sm btn-outline-secondary" type="submit">Cari</button>
            </div>
            </form>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Kdgapok</th>
                            <th>Kdkawin</th>
                            <th>Rekening</th>
                            <th>Nama Bank</th>
                            <th>Nama Rekening</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td class="text-center"></td>
                                <td><?= $pegawai['Nip18']; ?></td>
                                <td><?= $pegawai['Nama']; ?></td>
                                <td><?= $pegawai['KodeGolonganRuang']; ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="pb-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <?php if($pegawai['Nip18'] <> '') : ?>
                                        <a href="<?= base_url('pegawai/pilih-pegawai-hris/') . $pegawai['Nip18'] . '/' . $sk_id; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Pilih</a>
                                        <?php endif;  ?>
                                    </div>
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
        </div>
    </div>

</main>