<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tarif Darat</h1>
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
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>Orang</th>
                            <th>Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($tarif_darat as $r) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class="text-right"><?= number_format($r['orang'], 0, ',', '.'); ?></td>
                                <td class="text-right"><?= number_format($r['barang'], 0, ',', '.'); ?></td>
                                <td class="pb-0 pr-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('tarif_darat/update/') . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Ubah</a>
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
        </div>
    </div>

</main>