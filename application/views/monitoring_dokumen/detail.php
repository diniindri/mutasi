<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Dokumen Upload</h1>
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
        </div>
        <div class="col-lg-5">
            <form action="" method="post" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="nip" class="form-control" placeholder="NIP Pegawai">
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = $page + 1;
                        foreach ($upload as $r) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $r['nip']; ?></td>
                                <td><?= $r['file']; ?></td>
                                <td class="pb-0 pr-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('monitoring-dokumen/kp4/') . $r['id'] . '/' . $sk_id; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">KP4</a>
                                        <a href="<?= base_url('monitoring-dokumen/kuitansi/') . $r['id']  . '/' . $sk_id; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Kuitansi</a>
                                        <a href="<?= base_url('monitoring/spdawal/') . $r['id'] . '/' . $sk_id; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">SPD Awal</a>
                                        <a href="<?= base_url('monitoring/spdakhir/') . $r['id'] . '/' . $sk_id; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">SPD Akhir</a>
                                        <a href="<?= base_url('monitoring/ktp_art/') . $r['id'] . '/' . $sk_id; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">KTP ART</a>
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
            <?= $nip == null ? $pagination : ''; ?>
        </div>
    </div>

</main>