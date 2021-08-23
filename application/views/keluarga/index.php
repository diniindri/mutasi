<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Keluarga</h1>
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
            <a href="<?= base_url('pegawai/index/') . $sk_id; ?>" class="btn btn-sm btn-outline-secondary mt-1 mb-1"> Kembali ke halaman sebelumnya</a>
            <a href="<?= base_url('keluarga/create/') . $pegawai_id . '/' . $sk_id; ?>" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2"> Tambah Data</a>
            <a href="<?= base_url('keluarga/tarik-keluarga-gaji/') . $nip . '/' . $pegawai_id . '/' . $sk_id; ?>" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2" onclick="return confirm('Apakah Anda yakin akan melakukan tarik data keluarga?');"> Tarik Data Keluarga</a>
        </div>
        <div class="col-lg-5">
            <form action="" method="post" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="nama" class="form-control" placeholder="nama keluarga">
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
                            <th>Nama</th>
                            <th>Status Keluarga</th>
                            <th>Tanggal Lahir</th>
                            <th>Status Tunjangan</th>
                            <th>Status Usia</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = $page + 1;
                        foreach ($keluarga as $r) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $r['nama']; ?></td>
                                <td><?= $r['status_keluarga']; ?></td>
                                <td><?= date('d-m-Y', strtotime($r['tgllhr'])); ?></td>
                                <td><?= $r['kddapat'] == 1 ? 'Dapat' : 'Tidak'; ?></td>
                                <td><?= $r['sts'] == 0 ? 'Dewasa' : 'Infant'; ?></td>
                                <td class="pb-0 pr-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('keluarga/update/') . $r['id'] . '/' . $pegawai_id . '/' . $sk_id; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Ubah</a>
                                        <a href="<?= base_url('keluarga/delete/') . $r['id'] . '/' . $pegawai_id . '/' . $sk_id; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0" onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $nama == null ? $pagination : ''; ?>
        </div>
    </div>

</main>