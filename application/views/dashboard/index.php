<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th>#</th>
                            <th>Nomor</th>
                            <th>Uraian</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $no = 1;
                        foreach ($sk as $r) : ?>

                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $r['nomor']; ?></td>
                                <td><?= $r['uraian']; ?></td>
                                <td><?= $r['tanggal']; ?></td>
                                <td class="pb-0 pr-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>