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
            <!-- <form action="" method="post" autocomplete="off"> -->
            <?= form_open(); ?>
            <div class="input-group">
                <input type="text" name="nip" class="form-control" placeholder="Nama">
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
                            <th>Rute</th>
                            <th>Dokumen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = $page + 1;
                        foreach ($pegawai as $r) :
                            //tampilkan dokumen yg sudah diupload
                            $dataUpload = $this->dataupload->getPegawaiUpload($r['id']);
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $r['nip']; ?></td>
                                <td><?= $r['nmpeg']; ?></td>
                                <td><?= $r['asal']; ?>-<?= $r['tujuan']; ?></td>
                                <td class="pb-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <?php foreach ($dataUpload as $s) : ?>
                                            <a href="<?= base_url('assets/files/') . $s['file']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0" download="download"><?= $s['jenis']; ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                                <td class="pb-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('monitoring-dokumen/upload/') . $sk_id . '/' . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Upload</a>
                                        <a href="<?= base_url('monitoring-dokumen/hapus/') . $sk_id . '/'  . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Hapus</a>
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
            <?= $nmpeg == null ? $pagination : ''; ?>
        </div>
    </div>

</main>