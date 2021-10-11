<style>
    table {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
        padding: 0mm;
        border-spacing: 0px;
        font-size: 11px;
    }

    table.kosong {
        width: 100%;
        border: none;
        border-collapse: collapse;
        padding: 0mm;
        border-spacing: 0px;
        font-size: 11px;
    }

    th {
        border: 1px solid black;
        padding: 1mm;
    }

    td {
        border: 1px solid black;
        padding: 1mm;
    }

    td.kosong {
        border: none;
        padding: 1mm;
    }

    h5 {
        text-align: center;
        font-size: 13px;
        margin-top: 15px;
        margin-bottom: 2px;
        font-weight: 100;
    }

    p {
        text-align: justify;
        line-height: 1.6;
    }
</style>

<page backtop="5mm" backbottom="5mm" backleft="0mm" backright="0mm" footer="date;time">
    <page_header>
        <table class="kosong">
            <tr>
                <td class="kosong" style="width:450px; padding-bottom:0;">KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</td>
                <td class="kosong" style="padding-bottom:0;">Lampiran SPP Nomor <?= $sk['nospp']; ?></td>
            </tr>
            <tr>
                <td class="kosong" style="width:450px; padding-bottom:15px;">DIREKTORAT JENDERAL KEKAYAAN NEGARA</td>
                <td class="kosong" style="padding-bottom:15px;">Tanggal <?= tanggal($sk['tglspp']); ?></td>
            </tr>
        </table>
        <h5 style="margin-top:0; margin-bottom:10px;">DAFTAR NOMINATIF PEMBAYARAN (DNP)</h5>
        <p style="text-align: center; margin:0; padding:0; font-size: 11px;"><?= $sk['uraian']; ?></p>
        <p style="text-align: center; margin:0; padding:0; font-size: 11px;">Nomor <?= $sk['nomor']; ?> Tanggal <?= tanggal($sk['tanggal']); ?></p>
        <table>
            <tr>
                <td rowspan="2" style="text-align: center; width:3%; padding:0;">No</td>
                <td rowspan="2" style="text-align: center; width:20%;">Nama/NIP</td>
                <td rowspan="2" style="text-align: center; width:4%; padding:0;">Gol</td>
                <td rowspan="2" style="text-align: center; width:17%;">Rute</td>
                <td colspan="4" style="text-align: center; width:40%;">Biaya Angkutan</td>
                <td rowspan="2" style="text-align: center; width:15%;">Rekening</td>
            </tr>
            <tr>
                <td style="text-align: center; width:10%;">Pegawai</td>
                <td style="text-align: center; width:10%;">Barang</td>
                <td style="text-align: center; width:10%;">Lumpsum</td>
                <td style="text-align: center; width:11%;">Jumlah</td>
            </tr>
        </table>
    </page_header>
    <page_footer>

    </page_footer>

    <table style="margin-top: 130px;">
        <?php $no = 1;
        $j1 = 0;
        $j2 = 0;
        $j3 = 0;
        $j4 = 0;
        foreach ($biaya_pegawai as $r) : ?>
            <tr>
                <td style="text-align: center; width:3%;"><?= $no++; ?></td>
                <td style="text-align: left; width:20%;"><?= $r['nmpeg']; ?>/ <?= $r['nip']; ?></td>
                <td style="text-align: center; width:4%; padding:0;"><?= substr($r['kdgapok'], 0, 2); ?></td>
                <td style="text-align: center; width:17%; font-size:small; padding:0;"><?= $r['asal']; ?> - <?= $r['tujuan']; ?></td>
                <td style="text-align: right; width:10%;"><?= number_format($r['jml_jenis1'], 0, ',', '.'); ?></td>
                <td style="text-align: right; width:10%;"><?= number_format($r['jml_jenis2'], 0, ',', '.'); ?></td>
                <td style="text-align: right; width:10%;"><?= number_format($r['jml_jenis3'], 0, ',', '.'); ?></td>
                <td style="text-align: right; width:11%;"><?= number_format($r['jml_total'], 0, ',', '.'); ?></td>
                <td style="text-align: center; width:15%; padding:0;"><?= $r['rekening']; ?> <h5 style="margin-top: 0; font-size: xx-small;"><?= $r['nm_bank']; ?></h5>
                </td>
            </tr>
        <?php $j1 += $r['jml_jenis1'];
            $j2 += $r['jml_jenis2'];
            $j3 += $r['jml_jenis3'];
            $j4 += $r['jml_total'];
        endforeach; ?>
        <tr>
            <td style="text-align: center; width:44%;" colspan="4">Jumlah Total</td>
            <td style="text-align: right; width:10%;"><?= number_format($j1, 0, ',', '.'); ?></td>
            <td style="text-align: right; width:10%;"><?= number_format($j2, 0, ',', '.'); ?></td>
            <td style="text-align: right; width:10%;"><?= number_format($j3, 0, ',', '.'); ?></td>
            <td style="text-align: right; width:11%;"><?= number_format($j4, 0, ',', '.'); ?></td>
            <td style="text-align: center; width:15%;"></td>
        </tr>
    </table>

    <table class="kosong" style="padding-top:10px;">
        <tr>
            <td class="kosong" style="width:450px; padding-bottom:40px;">Bendahara Pengeluaran</td>
            <td class="kosong" style="padding-bottom:40px;">Pejabat Pembuat Komitmen</td>
        </tr>
        <tr>
            <td class="kosong" style="width:450px; padding-bottom:0;"><?= $bendahara['nama']; ?></td>
            <td class="kosong" style="padding-bottom:0;"><?= $ppk['nama']; ?></td>
        </tr>
    </table>


</page>