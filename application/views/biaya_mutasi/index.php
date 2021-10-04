<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Biaya Mutasi</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
        </div>
        <div class="col-lg-5">
            <form action="" method="post" autocomplete="off">
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
                                <td><?= date('d-m-Y', $r['tanggal']); ?></td>
                                <td><?= $r['uraian']; ?></td>
                                <td><?= $r['status'] == 1 ? 'Aktif' : 'Non Aktif'; ?></td>
                                <td class="pb-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('biaya-mutasi/detail/') . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                        <a href="<?= base_url('biaya-mutasi/dnp/') . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">DNP</a>
                                        <a href="<?= base_url('biaya-mutasi/excel/') . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Excel</a>
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