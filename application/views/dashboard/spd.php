<style>
    table {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
        padding: 0mm;
        border-spacing: 0px;
        font-size: 13px;
    }

    table.kosong {
        width: 100%;
        border: none;
        border-collapse: collapse;
        padding: 0mm;
        border-spacing: 0px;
        font-size: 13px;
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
        font-size: 14px;
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

    </page_header>
    <page_footer>

    </page_footer>

    <table class="kosong">
        <tr>
            <td class="kosong" style="width:60%;">KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</td>
            <td class="kosong" style="width:13%;">Lembar ke</td>
            <td class="kosong" style="width:2%;"> : </td>
            <td class="kosong" style="width:25%;">1 (satu)</td>
        </tr>
        <tr>
            <td class="kosong" style="width:60%;">DIREKTORAT JENDERAL KEKAYAAN NEGARA</td>
            <td class="kosong" style="width:13%;">Nomor</td>
            <td class="kosong" style="width:2%;"> : </td>
            <td class="kosong" style="width:25%;"> - <?= $laporan['nomor_spd']; ?></td>
        </tr>
    </table>

    <h5 style="margin-top: 30px;">SURAT PERJALANAN DINAS (SPD)</h5>


    <table style="margin-top:5px;">
        <tr>
            <td style="text-align:center; width:5%;">1</td>
            <td style="width:50%;">Pejabat Pembuat Komitmen</td>
            <td style="width:45%;"><?= $ppk['nama']; ?></td>
        </tr>
        <tr>
            <td style="text-align:center; width:5%;">2</td>
            <td style="width:50%;">Nama/NIP Pegawai Yang Melaksanakan Perjalanan Dinas</td>
            <td style="width:45%;"><?= $pegawai['nmpeg']; ?> / <?= $pegawai['nip']; ?></td>
        </tr>
        <tr>
            <td style="text-align:center; width:5%;">3</td>
            <td style="width:50%;">
                <table class="kosong">
                    <tr>
                        <td class="kosong">a. Pangkat/Gol</td>
                    </tr>
                    <tr>
                        <td class="kosong">b. Jabatan</td>
                    </tr>
                    <tr>
                        <td class="kosong">c. Tingkat Biaya Perjalanan Dinas</td>
                    </tr>
                </table>
            </td>
            <td style="width:45%;">
                <table class="kosong">
                    <tr>
                        <td class="kosong"><?= $pegawai['kdgapok']; ?></td>
                    </tr>
                    <tr>
                        <td class="kosong"> - </td>
                    </tr>
                    <tr>
                        <td class="kosong"> - </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center; width:5%;">4</td>
            <td style="width:50%;">Maksud Perjalanan Dinas</td>
            <td style="width:45%;">Perjalanan Dinas Pindah</td>
        </tr>
        <tr>
            <td style="text-align:center; width:5%;">5</td>
            <td style="width:50%;">Alat Angkutan Yang Dipergunakan</td>
            <td style="width:45%;">Udara/Darat</td>
        </tr>
        <tr>
            <td style="text-align:center; width:5%;">6</td>
            <td style="width:50%;">
                <table class="kosong">
                    <tr>
                        <td class="kosong">a. Tempat Berangkat</td>
                    </tr>
                    <tr>
                        <td class="kosong">b. Tempat Tujuan</td>
                    </tr>
                </table>
            </td>
            <td style="width:45%;">
                <table class="kosong">
                    <tr>
                        <td class="kosong"><?= $detail_sk['asal']; ?></td>
                    </tr>
                    <tr>
                        <td class="kosong"><?= $detail_sk['tujuan']; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center; width:5%;">7</td>
            <td style="width:50%;">
                <table class="kosong">
                    <tr>
                        <td class="kosong">a. Lamanya Perjalanan Dinas</td>
                    </tr>
                    <tr>
                        <td class="kosong">b. Tanggal Berangkat</td>
                    </tr>
                    <tr>
                        <td class="kosong">c. Tanggal Tiba di Tempat Baru</td>
                    </tr>
                </table>
            </td>
            <td style="width:45%;">
                <table class="kosong">
                    <tr>
                        <td class="kosong"> - </td>
                    </tr>
                    <tr>
                        <td class="kosong"> - </td>
                    </tr>
                    <tr>
                        <td class="kosong"> - </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center; width:5%; border-bottom:none;">8</td>
            <td style="width:50%; border-bottom:none; border-right:none;">Pengikut :</td>
            <td style="width:45%; border-bottom:none;"></td>
        </tr>
        <tr>
            <td style="text-align:center; width:5%;"></td>
            <td style="width:95%;" colspan="2">
                <table class="kosong">
                    <tr style="text-align:center;">
                        <td>No</td>
                        <td>Nama</td>
                        <td>Tgl Lahir</td>
                        <td>Status</td>
                    </tr>
                    <?php if ($keluarga) : ?>
                        <?php $no = 1;
                        foreach ($keluarga as $r) :
                            switch ($r['kdkeluarga']) {
                                case '1':
                                    $status = 'Isteri';
                                    break;
                                case '2':
                                    $status = 'Suami';
                                    break;
                                case '3':
                                    $status = 'Anak';
                                    break;
                                default:
                                    $status = 'Lainnya';
                                    break;
                            }
                        ?>
                            <tr>
                                <td style="text-align:center; width:5%;"><?= $no++; ?></td>
                                <td style="width:60%;"><?= $r['nama']; ?></td>
                                <td style="text-align:center; width:15%;"><?= date('d-m-Y', strtotime($r['tgllhr'])); ?></td>
                                <td style="width:20%;"><?= $status; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td style="width:5%;"> - </td>
                            <td style="width:60%;"> - </td>
                            <td style="width:15%;"> - </td>
                            <td style="width:20%;"> - </td>
                        </tr>
                    <?php endif; ?>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center; width:5%;">9</td>
            <td style="width:50%;">
                <table class="kosong">
                    <tr>
                        <td class="kosong">a. Dibebankan pada DIPA/POK</td>
                    </tr>
                    <tr>
                        <td class="kosong">b. Tahun Anggaran</td>
                    </tr>
                    <tr>
                        <td class="kosong">c. Akun</td>
                    </tr>
                </table>
            </td>
            <td style="width:45%;">
                <table class="kosong">
                    <tr>
                        <td class="kosong"><?= $laporan['dipa_kantor']; ?></td>
                    </tr>
                    <tr>
                        <td class="kosong"><?= $laporan['tahun_anggaran']; ?></td>
                    </tr>
                    <tr>
                        <td class="kosong"><?= $laporan['akun']; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center; width:5%;">10</td>
            <td style="width:50%;">Keterangan</td>
            <td style="width:45%;">Berdasarkan SK Nomor <?= $detail_sk['nomor']; ?> Tanggal <?= tanggal($detail_sk['tanggal']); ?></td>
        </tr>
    </table>

    <table class="kosong" style="padding-top:10px; margin-left:60%;">
        <tr>
            <td class="kosong" style="width:17%;">Dikeluarkan di</td>
            <td class="kosong" style="width:3%;">:</td>
            <td class="kosong" style="width:30%;"> - </td>
        </tr>
        <tr>
            <td class="kosong" style="width:17%; padding-top:0;">Pada Tanggal</td>
            <td class="kosong" style="width:3%;">:</td>
            <td class="kosong" style="width:30%;"> - </td>
        </tr>
    </table>
    <table class="kosong" style="padding-top:10px; margin-left:60%;">
        <tr>
            <td class="kosong" style="width:350px;">Pejabat Pembuat Komitmen</td>
        </tr>
    </table>
    <table class="kosong" style="padding-top:40px; margin-left:60%;">
        <tr>
            <td class="kosong" style="width:350px;"><?= $ppk['nama']; ?></td>
        </tr>
        <tr>
            <td class="kosong" style="width:350px; padding-top:0;">NIP <?= $ppk['nip']; ?></td>
        </tr>
    </table>


</page>

<page backtop="5mm" backbottom="5mm" backleft="0mm" backright="0mm" footer="date;time">
    <page_header>

    </page_header>
    <page_footer>

    </page_footer>

    <table style="margin-top:5px;">
        <tr style="padding-bottom: 100px;">
            <td style="text-align:center; width:5%;">I</td>
            <td style="width:45%;">
                <table class="kosong">
                    <tr>
                        <td class="kosong">Nomor : - <?= $laporan['nomor_spd']; ?></td>
                    </tr>
                    <tr>
                        <td class="kosong"><?= $pegawai['nmpeg']; ?></td>
                    </tr>
                    <tr>
                        <td class="kosong">NIP <?= $pegawai['nip']; ?></td>
                    </tr>
                    <tr>
                        <td class="kosong" style="padding-bottom: 150px;"> - </td>
                    </tr>
                </table>
            </td>
            <td style="width:50%;">
                <table class="kosong">
                    <tr>
                        <td class="kosong">Berangkat Dari : <?= $detail_sk['asal']; ?></td>
                    </tr>
                    <tr>
                        <td class="kosong">(Tempat kedudukan)</td>
                    </tr>
                    <tr>
                        <td class="kosong">Ke : <?= $detail_sk['tujuan']; ?></td>
                    </tr>
                    <tr>
                        <td class="kosong" style="padding-bottom: 150px;">Pada Tanggal : </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center; width:5%;">II</td>
            <td style="width:45%;">
                <table class="kosong">
                    <tr>
                        <td class="kosong">Tiba di : <?= $detail_sk['tujuan']; ?></td>
                    </tr>
                    <tr>
                        <td class="kosong" style="padding-bottom: 150px;">Pada Tanggal : </td>
                    </tr>
                </table>
            </td>
            <td style="width:50%;">
            </td>
        </tr>
        <tr>
            <td style="text-align:center; width:5%;">III</td>
            <td style="width:45%;">
            </td>
            <td style="width:50%;">
                <table class="kosong" style="width:100%;">
                    <tr>
                        <td class="kosong" style="width:100%;">
                            <p style="margin-top:0;">Telah diperiksa, dengan keterangan bahwa perjalanan tersebut diatas benar dilaksanakan atas perintahnya dan semata-mata untuk kepentingan jabatan dalam waktu yang sesiangkat-singkatnya.</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="kosong" style="padding-top: 10px; padding-bottom: 60px;">Pejabat Pembuat Komitmen</td>
                    </tr>
                    <tr>
                        <td class="kosong"><?= $ppk['nama']; ?></td>
                    </tr>
                    <tr>
                        <td class="kosong" style="padding-top: 0;">NIP <?= $ppk['nip']; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center; width:5%;">IV</td>
            <td style="width:45%;">CATATAN LAIN LAIN</td>
            <td style="width:50%;">DIPA Tahun Anggaran <?= $laporan['tahun_anggaran']; ?></td>
        </tr>
        <tr>
            <td style="text-align:center; width:5%;">V</td>
            <td style="width:95%;" colspan="2">
                <p style="margin-top: 0; margin-bottom: 0;">PERHATIAN</p>
                <p style="margin-top: 0;">PPK yang menerbitkan SPD, Pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat/tiba, serta bendahara pengeluaran bertanggung jawab berdasarkan peraturan-peraturan Keuangan Negara apabila Negara menderita rugi akibat kesalahan, kelalaian, dan kealpaannya.</p>
            </td>
        </tr>

    </table>



</page>