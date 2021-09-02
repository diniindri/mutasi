<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Timeline</h1>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <h5 class="card-header">Daftar SK</h5>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach ($sk as $r) : ?>
                            <a href="<?= base_url('timeline/index/') . $r['pegawai_id']; ?>" class="btn btn-sm btn-outline-secondary mb-2 text-left p-2"><?= $r['nomor']; ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <h5 class="card-header">Status Pembayaran</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-center">
                                <tr class="align-middle">
                                    <th>No</th>
                                    <th>Uraian</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($timeline as $r) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $r['nama']; ?></td>
                                        <td><?= $r['keterangan']; ?></td>
                                        <td><?= date('d-m-Y', $r['tanggal']); ?></td>
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