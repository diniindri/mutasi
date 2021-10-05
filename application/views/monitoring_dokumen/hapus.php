<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Hapus Dokumen</h1>
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
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>Jenis Dokumen</th>
                            <th>Tanggal</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($dokumen as $r) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $r['jenis']; ?></td>
                                <td><?= date('d-m-Y', $r['date_created']); ?></td>
                                <td> <a href="<?= base_url('assets/files/') . $r['file']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0" download="download">download</a></td>
                                <td class="pb-0">
                                    <a href="<?= base_url('monitoring-dokumen/delete/') . $sk_id . '/' . $pegawai_id . '/' . $r['id'] . '/' . $r['file']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0" onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>