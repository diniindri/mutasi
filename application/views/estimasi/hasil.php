<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Hasil Estimasi</h1>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <p>Hasil Estimasi Perhitungan Biaya Mutasi adalah perkiraan jumlah biaya mutasi belum termasuk pemotongan biaya anak dibawah 2 tahun dan pemotongan 50% untuk biaya pengepakan dan transportasi darat untuk luar pulau jawa (min 100km) dan pulau jawa (min 50km), serta kebijakan lainnya.</p>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            <a href="<?= base_url('estimasi'); ?>" class="btn btn-sm btn-outline-secondary mt-1 mb-1">Kembali ke Halaman Sebelumnya</a>
        </div>
        <div class="col-lg-5">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-8">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>Jenis Angkutan</th>
                            <th>Satuan</th>
                            <th>Jarak</th>
                            <th>Tarif</th>
                            <th>Jumlah</th>
                            <th>Uraian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        $jml = 0;
                        foreach ($hasil as $r) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class="text-left"><?= $r['angkutan']; ?></td>
                                <td class="text-right"><?= number_format($r['satuan'], 0, ',', '.'); ?></td>
                                <td class="text-right"><?= $r['jarak']; ?></td>
                                <td class="text-right"><?= number_format($r['tarif'], 0, ',', '.'); ?></td>
                                <td class="text-right"><?= number_format($r['jumlah'], 0, ',', '.'); ?></td>
                                <td class="text-left"><?= $r['uraian']; ?></td>
                            </tr>
                        <?php $jml += $r['jumlah'];
                        endforeach; ?>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="5" class="text-center">Jumlah</th>
                            <th class="text-right"><?= number_format($jml, 0, ',', '.'); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class=" row">
        <div class="col-lg-6">
        </div>
    </div>

</main>