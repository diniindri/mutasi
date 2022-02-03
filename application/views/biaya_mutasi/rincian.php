<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Rincian</h1>
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
            <a href="<?= base_url('biaya-mutasi/detail/') . $sk_id . '/a'; ?>" class="btn btn-sm btn-outline-secondary mt-1 mb-1"> Sebelumnya</a>
        </div>
        <div class="col-lg-5">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Angkutan</th>
                            <th>Satuan</th>
                            <th>Jarak</th>
                            <th>Tarif</th>
                            <th>Jumlah</th>
                            <th>Uraian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        $total = 0;
                        foreach ($biaya as $r) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $r['nama_jenis']; ?></td>
                                <td><?= $r['nama_angkutan']; ?></td>
                                <td class="text-right"><?= number_format($r['satuan'], 2, ',', '.'); ?></td>
                                <td class="text-right"><?= number_format($r['jarak'], 0, ',', '.'); ?></td>
                                <td class="text-right"><?= number_format($r['tarif'], 0, ',', '.'); ?></td>
                                <td class="text-right"><?= number_format($r['jumlah'], 0, ',', '.'); ?></td>
                                <td><?= $r['uraian']; ?></td>
                            </tr>
                        <?php
                            $total += $r['jumlah'];
                        endforeach; ?>
                        <tr>
                            <td colspan="6" class="text-center">Jumlah Total</td>
                            <td class="text-right"><?= number_format($total, 0, ',', '.'); ?></td>
                            <td colspan="2"></td>
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