<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Daftar Payroll</h1>
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
            <a href="<?= base_url('payroll/create/') . $sk_id; ?>" class="btn btn-sm btn-outline-secondary mt-1 mb-1"> Tambah Data</a>
        </div>
        <div class="col-lg-5">
            <!-- <form action="" method="post" autocomplete="off"> -->
            <?= form_open(); ?>
            <div class="input-group">
                <input type="text" name="uraian" class="form-control" placeholder="uraian Payroll">
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
                            <th>Uraian</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Nominal</th>
                            <th>SPP</th>
                            <th>Tgl SPP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = $page + 1;
                        $jml = 0;
                        $nmnl = 0;
                        foreach ($payroll as $r) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $r['uraian']; ?></td>
                                <td><?= date('d-m-Y', $r['tanggal']); ?></td>
                                <td class="text-right"><?= number_format($r['jumlah'], 0, ',', '.'); ?></td>
                                <td class="text-right"><?= number_format($r['nominal'], 0, ',', '.'); ?></td>
                                <td><?= $r['nospp']; ?></td>
                                <td><?= date('d-m-Y', $r['tglspp']); ?></td>
                                <td class="pb-0">
                                    <?php if ($r['status'] == 0) : ?>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= base_url('payroll/update/') . $r['sk_id'] . '/' . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Ubah</a>
                                            <a href="<?= base_url('payroll/delete/') . $r['sk_id'] . '/' . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0" onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</a>
                                            <a href="<?= base_url('payroll/pegawai/') . $r['sk_id'] . '/'  . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Pegawai</a>
                                            <a href="<?= base_url('payroll/dnp/') . $r['sk_id'] . '/'  . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">DNP</a>
                                            <a href="<?= base_url('payroll/excel/') . $r['sk_id'] . '/'  . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Excel</a>
                                            <a href="<?= base_url('payroll/proses-payroll/') . $r['sk_id'] . '/'  . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0" onclick="return confirm('Apakah Anda yakin akan memproses payroll ini?');">Proses Payroll</a>
                                        </div>
                                    <?php else : ?>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= base_url('payroll/pegawai-payroll/') . $r['sk_id'] . '/'  . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Pegawai</a>
                                            <a href="<?= base_url('payroll/batal-payroll/') . $r['sk_id'] . '/'  . $r['id']; ?>" class="btn btn-sm btn-outline-secondary pt-0 pb-0" onclick="return confirm('Apakah Anda yakin akan membatalkan payroll ini?');">Batal Payroll</a>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php $jml += $r['jumlah'];
                            $nmnl += $r['nominal'];
                        endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-center">Total</td>
                            <td class="text-right"><?= number_format($jml, 0, ',', '.'); ?></td>
                            <td class="text-right"><?= number_format($nmnl, 0, ',', '.'); ?></td>
                            <td></td>
                        </tr>
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