<style type="text/css">
    table.page_header {
        width: 100%;
        border: none;
        padding: 0mm;
        border-spacing: 0px;
        margin-top: 5px;
        margin-left: 20px;
        align-content: center;
        align-items: center;
        align-self: center;
        box-align: center;
        text-align: center;
    }

    table.page_header_garis {
        width: 100%;
        border: none;
        border-bottom: solid 1mm #77797a;
        padding: 0mm;
        border-spacing: 0px;
        margin-top: 5px;
        margin-left: 20px;
    }

    table.page_footer {
        width: 100%;
        border: none;
        padding: 0mm;
        font-size: 7px;
    }

    td.logo {
        text-align: center;
    }

    td.kop1 {
        text-align: center;
        font-size: 17px;
        width: 80%;
    }

    td.kop2 {
        text-align: center;
        font-size: 15px;
    }

    td.kop3 {
        text-align: center;
        font-size: 9px;
        line-height: 7px;
        margin-right: 100px;
    }

    td.garis {
        width: 95%;
        text-align: center;
        font-size: 9px;
        line-height: 7px;
    }

    #judul1 {
        text-align: center;
        font-size: 15px;
    }

    #judul2 {
        text-align: center;
        font-size: 13px;
    }

    #judul3 {
        text-align: left;
        font-size: 13px;
    }

    table.page {
        width: 100%;
        border: 1px;
        padding: 1mm;
        font-size: 13px;
    }

    table.detail {
        width: 100%;
        padding: 0mm;
        font-size: 13px;
        border-collapse: collapse;
        border: 1px solid black;
    }

    td.data {
        border: 1px solid black;
        font-size: 11px;
    }

    td.angka {
        border: 1px solid black;
        text-align: right;
        padding-right: 5px;
        font-size: 11px;
    }

    td.head {
        border: 1px solid black;
        font-size: 13px;
    }

    td.headangka {
        border: 1px solid black;
        text-align: right;
        padding-right: 5px;
        font-size: 13px;
    }

    table.isi {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
        padding: 0mm;
        border-spacing: 0px;
        font-size: 13px;
    }

    td.isi {
        border: 1px solid black;
        padding: 1mm;
    }
</style>

<page backtop="40mm" backbottom="0mm" backleft="5mm" backright="5mm">

    <page_header>
        <table class="page_header" cellspacing="0px" cellpadding="0px">
            <tr>
                <td class="logo" rowspan="10">
                    <img src="<?= FCPATH . 'assets/img/logo.jpeg'; ?>" alt="logo kemenkeu" width="100">
                </td>
                <td class="kop1">
                    <b>KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</b>
                </td>
            </tr>
            <tr>
                <td class="kop2">
                    <b>DIREKTORAT JENDERAL KEKAYAAN NEGARA</b>
                </td>
            </tr>
            <tr>
                <td class="kop2" style="line-height:1px;">
                    <b>SEKRETARIAT DIREKTORAT JENDERAL</b>
                </td>
            </tr>
            <tr>
                <td class="kop2">
                    <b></b><br><br>
                </td>
            </tr>
            <tr>
                <td class="kop3">
                    GEDUNG SYAFRUDDIN PRAWIRANEGARA II LANTAI 7-10
                </td>
            </tr>
            <tr>
                <td class="kop3">
                    JALAN LAPANGAN BANTENG TIMUR NO 2-4 JAKARTA 10710 KOTAK POS 3169
                </td>
            </tr>
            <tr>
                <td class="kop3">
                    TELEPON (021) 3847903; FAKSIMILE (021) 3847742; SITUS www.djkn.kemenkeu.go.id
                </td>
            </tr>
            <tr>
                <td class="kop3">
                </td>
            </tr>
            <tr>
                <td class="kop3">
                </td>
            </tr>
        </table>
        <table class="page_header_garis" cellspacing="0px" cellpadding="0px">
            <tr>
                <td class="garis"></td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table class="page_footer">
        </table>
    </page_footer>

    <div id="judul1" style="margin-top: 10px;">
        RINCIAN BIAYA PERJALANAN DINAS
    </div>

    <table class="kosong" style="margin-top: 20px;">
        <tr>
            <td class="kosong">Lampiran SPD No</td>
            <td class="kosong"> : </td>
            <td class="kosong"> <?= $pegawai['no_spd']; ?> <?= $laporan['nomor_spd']; ?></td>
        </tr>
        <tr>
            <td class="kosong">Tanggal</td>
            <td class="kosong"> : </td>
            <td class="kosong"> <?= tanggal($pegawai['tgl_spd']); ?> </td>
        </tr>
    </table>

    <table class="isi" style="margin-top: 5px;">
        <tr>
            <td class="isi" style="text-align:center; width:5%;">No</td>
            <td class="isi" style="text-align:center; width:50%;" colspan="2">Rincian Biaya</td>
            <td class="isi" style="text-align:center; width:13%;">Nominal</td>
            <td class="isi" style="text-align:center; width:32%;">Keterangan</td>
        </tr>
        <!-- angkutan orang -->
        <tr>
            <td class="isi" style="text-align:center; width:5%; border-bottom:none;">1</td>
            <td class="isi" style="text-align:left; width:50%; border-bottom:none;" colspan="2">Biaya Angkutan Pegawai dan Keluarga</td>
            <td class="isi" style="text-align:center; width:13%; border-bottom:none;"></td>
            <td class="isi" style="text-align:center; width:32%; border-bottom:none;"></td>
        </tr>
        <?php $jml_orang = 0;
        foreach ($biaya_orang as $r) : ?>
            <tr>
                <td class="isi" style="text-align:center; width:5%; border-bottom:none;"></td>
                <td class="isi" style="text-align:left; width:18%; border-bottom:none; border-right:none; padding-left:10px; padding-right:0;"> - <?= $r['nama_angkutan']; ?></td>
                <td class="isi" style="text-align:left; width:32%; border-bottom:none; padding-left:0; padding-right:0;">
                    ( <?= number_format($r['satuan'], 1, ',', '.'); ?> orang X
                    <?= $r['jarak'] == 0 ? '' : number_format($r['jarak'], 0, ',', '.') . ' km X '; ?>
                    <?= number_format($r['tarif'], 0, ',', '.'); ?> )
                </td>
                <td class="isi" style="text-align:right; width:13%; border-bottom:none;"><?= number_format($r['jumlah'], 0, ',', '.'); ?></td>
                <td class="isi" style="text-align:left; width:32%; border-bottom:none; font-size:small;"><?= $r['uraian']; ?></td>
            </tr>
        <?php $jml_orang += $r['jumlah'];
        endforeach; ?>
        <!-- angkutan barang -->
        <tr>
            <td class="isi" style="text-align:center; width:5%; border-bottom:none; padding-top:10px;">2</td>
            <td class="isi" style="text-align:left; width:50%; border-bottom:none; padding-top:10px;" colspan="2">Biaya Angkutan Barang dan Pengepakan</td>
            <td class="isi" style="text-align:center; width:13%; border-bottom:none; padding-top:10px;"></td>
            <td class="isi" style="text-align:center; width:32%; border-bottom:none; padding-top:10px;"></td>
        </tr>
        <?php $jml_barang = 0;
        foreach ($biaya_barang as $r) : ?>
            <tr>
                <td class="isi" style="text-align:center; width:5%; border-bottom:none;"></td>
                <td class="isi" style="text-align:left; width:18%; border-bottom:none; border-right:none; padding-left:10px;"> - <?= $r['nama_angkutan']; ?></td>
                <td class="isi" style="text-align:left; width:32%; border-bottom:none;">
                    ( <?= number_format($r['satuan'], 0, ',', '.'); ?> m3 X
                    <?= $r['jarak'] == 0 ? '' : number_format($r['jarak'], 0, ',', '.') . ' km X '; ?>
                    <?= number_format($r['tarif'], 0, ',', '.'); ?> )
                </td>
                <td class="isi" style="text-align:right; width:13%; border-bottom:none;"><?= number_format($r['jumlah'], 0, ',', '.'); ?></td>
                <td class="isi" style="text-align:left; width:32%; border-bottom:none;  font-size:small;"><?= $r['uraian']; ?></td>
            </tr>
        <?php $jml_barang += $r['jumlah'];
        endforeach; ?>
        <!-- lumpsum -->
        <tr>
            <td class="isi" style="text-align:center; width:5%; border-bottom:none; padding-top:10px;">3</td>
            <td class="isi" style="text-align:left; width:50%; border-bottom:none; padding-top:10px;" colspan="2">Uang Harian Perjalanan Dinas Pegawai dan Keluarga</td>
            <td class="isi" style="text-align:center; width:13%; border-bottom:none; padding-top:10px;"></td>
            <td class="isi" style="text-align:center; width:32%; border-bottom:none; padding-top:10px;"></td>
        </tr>
        <?php $jml_lumpsum = 0;
        foreach ($biaya_lumpsum as $r) : ?>
            <tr>
                <td class="isi" style="text-align:center; width:5%;"></td>
                <td class="isi" style="text-align:left; width:18%; border-right:none; padding-left:10px; padding-right:0;"> - <?= $r['nama_angkutan']; ?></td>
                <td class="isi" style="text-align:left; width:32%; padding-left:0; padding-right:0;">
                    ( <?= number_format($r['satuan'], 0, ',', '.'); ?> orang X
                    <?= number_format($r['jarak'], 0, ',', '.'); ?> hari X
                    <?= number_format($r['tarif'], 0, ',', '.'); ?> )
                </td>
                <td class="isi" style="text-align:right; width:13%;"><?= number_format($r['jumlah'], 0, ',', '.'); ?></td>
                <td class="isi" style="text-align:left; width:32%;  font-size:small;"><?= $r['uraian']; ?></td>
            </tr>
        <?php $jml_lumpsum += $r['jumlah'];
        endforeach; ?>
        <tr>
            <td class="isi" style="text-align:center; width:5%;"></td>
            <td class="isi" style="text-align:center; width:50%;" colspan="2">Jumlah</td>
            <td class="isi" style="text-align:right; width:13%;"><?= number_format($jml_orang + $jml_barang + $jml_lumpsum, 0, ',', '.'); ?></td>
            <td class="isi" style="text-align:center; width:32%;"></td>
        </tr>
        <tr>
            <td class="isi" style="text-align:left; width:100%;" colspan="5"><i>Terbilang : <?= terbilang($jml_orang + $jml_barang + $jml_lumpsum); ?> rupiah.</i></td>
        </tr>
    </table>
    <table class="kosong" style="padding-top:5px;">
        <tr>
            <td class="kosong" style="width:350px;">Telah dibayar sejumlah :</td>
            <td class="kosong">Telah menerima sejumlah :</td>
        </tr>
        <tr>
            <td class="kosong" style="width:350px;">Rp <?= number_format($jml_orang + $jml_barang + $jml_lumpsum, 0, ',', '.'); ?>,-</td>
            <td class="kosong">Rp <?= number_format($jml_orang + $jml_barang + $jml_lumpsum, 0, ',', '.'); ?>,-</td>
        </tr>
        <tr>
            <td class="kosong" style="width:350px; padding-top:10px;">Bendahara Pengeluaran</td>
            <td class="kosong" style="padding-top:10px;">Yang Menerima</td>
        </tr>
    </table>
    <table class="kosong" style="padding-top:50px;">
        <tr>
            <td class="kosong" style="width:350px;"><?= $bendahara['nama']; ?></td>
            <td class="kosong"><?= $pegawai['nmpeg']; ?></td>
        </tr>
        <tr>
            <td class="kosong" style="width:350px;">NIP <?= $bendahara['nip']; ?></td>
            <td class="kosong">NIP <?= $pegawai['nip']; ?></td>
        </tr>
    </table>
    <hr>
    <table class="kosong" style="text-align:center; width:100%;">
        <tr>
            <td class="kosong" style="text-align:center; width:100%;">PERHITUNGAN SPD RAMPUNG</td>
        </tr>
    </table>
    <table class="kosong" style="padding-top:5px;">
        <tr>
            <td class="kosong" style="width:160px;">Ditetapkan sejumlah</td>
            <td class="kosong" style="width:185px;"> : Rp <?= number_format($jml_orang + $jml_barang + $jml_lumpsum, 0, ',', '.'); ?>,-</td>
            <td class="kosong"></td>
        </tr>
        <tr>
            <td class="kosong" style="width:160px;">Yang telah dibayar semula</td>
            <td class="kosong" style="width:185px;"> : - </td>
            <td class="kosong"></td>
        </tr>
        <tr>
            <td class="kosong" style="width:160px;">Sisa kurang/lebih</td>
            <td class="kosong" style="width:185px;"> : - </td>
            <td class="kosong">Pejabat Pembuat Komitmen</td>
        </tr>
    </table>
    <table class="kosong" style="padding-top:50px;">
        <tr>
            <td class="kosong" style="width:350px;"></td>
            <td class="kosong"><?= $ppk['nama']; ?></td>
        </tr>
        <tr>
            <td class="kosong" style="width:350px;"></td>
            <td class="kosong">NIP <?= $ppk['nip']; ?></td>
        </tr>
    </table>

</page>