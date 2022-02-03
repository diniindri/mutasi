<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">SK Mutasi</h1>
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
            <a href="<?= base_url('sk-mutasi/create'); ?>" class="btn btn-sm btn-outline-secondary mt-1 mb-1"> Tambah Data</a>
        </div>
        <div class="col-lg-5">
            <!-- <form action="" method="post" autocomplete="off"> -->
            <?= form_open(); ?>
            <div class="input-group">
                <input type="text" name="uraian" class="form-control" placeholder="uraian sk">
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
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>Uraian</th>
                            <th>SPP</th>
                            <th>Tgl SPP</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = $page + 1;
                        foreach ($sk as $r) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $r['nomor']; ?></td>
                                <td><?= tanggal($r['tanggal']); ?></td>
                                <td><?= $r['uraian']; ?></td>
                                <td><?= $r['nospp']; ?></td>
                                <td><?= tanggal($r['tglspp']); ?></td>
                                <td><?= $r['status'] == 1 ? 'Aktif' : 'Non Aktif'; ?></td>
                                <td class="pb-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('sk-mutasi/update/') . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Ubah</a>
                                        <a href="<?= base_url('sk-mutasi/delete/') . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0" onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</a>
                                        <a href="<?= base_url('pegawai/index/') . $r['id'] . '/a'; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                        <a href="<?= base_url('jadwal/detail/') . $r['id'] . '/a'; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Jadwal</a>
                                        <a href="<?= base_url('sk-mutasi/nd/') . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">ND</a>
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
            <?= $uraian == null ? $pagination : ''; ?>
        </div>
    </div>

</main>