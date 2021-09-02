<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>
    <div class="row mb-3">
        <div class="col">
            <?php foreach ($sk as $r) : ?>
                <a href="<?= base_url('dashboard/index/') . $r['pegawai_id']; ?>" class="btn btn-sm btn-outline-secondary mt-1 mb-1"><?= $r['nomor']; ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <h6 class="card-header">Keterangan SK</h6>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-center">
                                <tr class="align-middle">
                                    <th>Jenis</th>
                                    <th>Uraian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tanggal SK</td>
                                    <td><?= $detail_sk['tanggal'] == '' ? '' : date('d-m-Y', $detail_sk['tanggal']); ?></td>
                                </tr>
                                <tr>
                                    <td>Uraian SK</td>
                                    <td><?= $detail_sk['uraian']; ?></td>
                                </tr>
                                <tr>
                                    <td>Rute Mutasi</td>
                                    <td><?= $detail_sk['asal']; ?> - <?= $detail_sk['tujuan']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <h6 class="card-header">Rute & Rincian Biaya Mutasi</h6>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Jenis</th>
                                    <th scope="col">Rute</th>
                                    <th scope="col">Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                $jns = '';
                                foreach ($biaya as $r) :
                                ?>
                                    <tr>
                                        <th scope="row"><?= $r['nama_jenis'] == $jns ? '' : $r['nama_jenis']; ?></th>
                                        <td><?= $r['uraian']; ?></td>
                                        <td class="text-right"><?= number_format($r['jumlah'], 0, ',', '.'); ?></td>
                                    </tr>
                                <?php
                                    $total += $r['jumlah'];
                                    $jns = $r['nama_jenis'];
                                endforeach; ?>
                                <tr>
                                    <th scope="row">Total</th>
                                    <td class="text-right"></td>
                                    <td class="text-right"><?= number_format($total, 0, ',', '.'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-2">
                <h6 class="card-header">Download Dokumen</h6>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Uraian</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>KP4 <small>(download via alika.kemenkeu.go.id)</small></td>
                                    <td class="pb-0 pr-0">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="https://alika.kemenkeu.go.id/" target="_blank" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Download</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>SPD</td>
                                    <td class="pb-0 pr-0">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Download</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Rincian Biaya</td>
                                    <td class="pb-0 pr-0">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Download</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <h6 class="card-header">Upload Dokumen</h6>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Uraian</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>KP4</td>
                                    <td class="pb-0 pr-0">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="" class="btn btn-sm btn-outline-danger pt-0 pb-0">Belum Upload</a>
                                        </div>
                                    </td>
                                    <td class="pb-0 pr-0">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="alika.kemenkeu.go.id" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Upload</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>SPD</td>
                                    <td class="pb-0 pr-0">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="" class="btn btn-sm btn-outline-success pt-0 pb-0">Sudah Upload</a>
                                        </div>
                                    </td>
                                    <td class="pb-0 pr-0">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Upload</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Rincian Biaya</td>
                                    <td class="pb-0 pr-0">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="" class="btn btn-sm btn-outline-danger pt-0 pb-0">Belum Upload</a>
                                        </div>
                                    </td>
                                    <td class="pb-0 pr-0">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Upload</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>