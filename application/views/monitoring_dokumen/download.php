<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Download Dokumen</h1>
    </div>
    <div class="row">
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
                                <?php $no = 1;
                                foreach ($download as $r) : ?>
                                    <tr>
                                        <th scope="row"><?= $no++; ?></th>
                                        <td><?= $r['nama']; ?></td>
                                        <td class="pb-0 pr-0">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?= $r['url']; ?>" target="_blank" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Download</a>
                                            </div>
                                        </td>
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