<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dateline</h1>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <h5 class="card-header">Daftar SK</h5>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach ($sk as $r) : ?>
                            <a href="<?= base_url('dateline/index/') . $r['sk_id']; ?>" class="btn btn-sm btn-outline-secondary mb-1 text-left p-1 <?= $sk_id == $r['sk_id'] ? 'active' : ''; ?>"><?= $r['nomor']; ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <?php if ($file !== null) : ?>
                <div class="alert alert-dark" role="alert">
                    Silahkan Download Nota Dinas ketentuan Pembayaran Biaya Mutasi <a href="<?= base_url('assets/files/') . $file; ?>" download="download">di sini</a>
                </div>
            <?php endif; ?>
            <div class="card">
                <h5 class="card-header">Dateline Proses Mutasi</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-center">
                                <tr class="align-middle">
                                    <th>No</th>
                                    <th>Uraian</th>
                                    <th>PIC</th>
                                    <th>Tanggal Awal</th>
                                    <th>Tanggal Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($jadwal as $r) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $r['uraian']; ?></td>
                                        <td class="text-center"><?= $r['pic']; ?></td>
                                        <td class="text-center"><?= tanggal($r['tglawal']); ?></td>
                                        <td class="text-center"><?= tanggal($r['tglakhir']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>