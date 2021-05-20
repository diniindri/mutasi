<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
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
                                <td><?= $no++; ?></td>
                                <td><?= $r['nomor']; ?></td>
                                <td><?= $r['uraian']; ?></td>
                                <td><?= $r['tanggal']; ?></td>
                                <td>
                                    <a href="" class="btn btn-sm btn-outline-success">Detail</a>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>