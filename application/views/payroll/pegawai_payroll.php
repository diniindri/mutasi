<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail</h1>
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
                    <input type="text" name="nmpeg" class="form-control" placeholder="nama pegawai">
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
                            <th>Nominal</th>
                            <th>Rekening</th>
                            <th>Nama Bank</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = $page + 1;
                        $jml = 0;
                        foreach ($pegawai as $r) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $r['nip']; ?></td>
                                <td><?= $r['nmpeg']; ?></td>
                                <td><?= $r['asal']; ?>-<?= $r['tujuan']; ?></td>
                                <td class="text-right"><?= number_format($r['nominal'], 0, ',', '.'); ?></td>
                                <td><?= $r['rekening']; ?></td>
                                <td><?= $r['nm_bank']; ?></td>
                            </tr>
                        <?php $jml += $r['nominal'];
                        endforeach; ?>
                        <tr>
                            <td class="text-center" colspan="4">Jumlah</td>
                            <td class="text-right"><?= number_format($jml, 0, ',', '.'); ?></td>
                            <td colspan="3"></td>
                        </tr>
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