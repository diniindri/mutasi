<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Estimasi</h1>
    </div>

    <?= form_open(); ?>

    <div class="row">
        <div class="col-lg-3">
            <div class="form-group mb-2">
                <label for="">Golongan:</label>
                <select name="gol" class="form-control">
                    <?php foreach ($gol as $r) : ?>
                        <option value="<?= $r['gol']; ?>"><?= $r['gol']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-2">
                <label for="">Status Keluarga:</label>
                <select name="kdkawin" class="form-control">
                    <?php foreach ($kdkawin as $r) : ?>
                        <option value="<?= $r['kdkawin']; ?>"><?= $r['kdkawin']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-2">
                <label for="">Asal:</label>
                <select name="asal" class="form-control">
                    <?php foreach ($asal as $r) : ?>
                        <option value="<?= $r['asal']; ?>"><?= $r['asal']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-2">
                <label for="">Tujuan:</label>
                <select name="tujuan" class="form-control">
                    <?php foreach ($tujuan as $r) : ?>
                        <option value="<?= $r['tujuan']; ?>"><?= $r['tujuan']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Hitung</button>
            </div>
        </div>
    </div>

    </form>

</main>