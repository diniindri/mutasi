<?php

use Spipu\Html2Pdf\Html2Pdf;

class Biaya_mutasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Data_sk_model', 'sk');
        $this->load->model('Data_biaya_model', 'biaya');
        $this->load->model('Data_pegawai_model', 'pegawai');
        $this->load->model('Ref_rute_model', 'rute');
        $this->load->model('Ref_sub_rute_model', 'subrute');
        $this->load->model('Ref_tarif_darat_model', 'tarif_darat');
        $this->load->model('Ref_packing_model', 'packing');
        $this->load->model('Ref_packing_model', 'packing');
        $this->load->model('Ref_provinsi_model', 'provinsi');
        $this->load->model('Ref_uang_harian_model', 'uang_harian');
        $this->load->model('Ref_pejabat_model', 'pejabat');
        $this->load->model('View_biaya_pegawai_model', 'biaya_pegawai');
        $this->load->model('Data_timeline_model', 'timeline');
    }

    public function index()
    {
        // menangkap data pencarian uraian sk
        $uraian = $this->input->post('uraian');

        // settingan halaman
        $config['base_url'] = base_url('biaya-mutasi/index');
        $config['total_rows'] = $this->sk->countSk();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['uraian'] = $uraian;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian uraian sk
        if ($uraian) {
            $data['page'] = 0;
            $offset = 0;
            $data['sk'] = $this->sk->findSk($uraian, $limit, $offset);
        } else {
            $data['sk'] = $this->sk->getSk($limit, $offset);
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('biaya_mutasi/index', $data);
        $this->load->view('template/footer');
    }

    public function detail($sk_id = null)
    {
        // cek apakah ada sk id apa tidak
        if (!isset($sk_id)) show_404();

        // mengirim data id sk ke view
        $data['sk_id'] = $sk_id;

        // menangkap data pencarian nmpeg
        $nmpeg = $this->input->post('nmpeg');

        // settingan halaman
        $config['base_url'] = base_url('biaya-mutasi/detail/' . $sk_id . '');
        $config['total_rows'] = $this->pegawai->countPegawaiMutasi($sk_id);
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
        $data['nmpeg'] = $nmpeg;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian nmpeg 
        if ($nmpeg) {
            $data['page'] = 0;
            $offset = 0;
            $data['pegawai'] = $this->pegawai->findPegawai($sk_id, $nmpeg, $limit, $offset);
        } else {
            $data['pegawai'] = $this->pegawai->getPegawai($sk_id, $limit, $offset);
        }

        // meload view pada pegawai/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('biaya_mutasi/detail', $data);
        $this->load->view('template/footer');
    }

    public function hitung($pegawai_id = null, $ref_rute_id = null, $sk_id = null)
    {
        // cek apakah ada sk id apa tidak
        if (!isset($pegawai_id)) show_404();
        if (!isset($ref_rute_id)) show_404();
        if (!isset($sk_id)) show_404();

        // tarik data pegawai yang dipakai untuk perhitungan
        $pegawai = $this->pegawai->getDetailPegawai($pegawai_id);
        // -- mulai hitung anggota keluarga
        $ybs = intval(substr($pegawai['kdkawin'], 0, 1));
        $istri = intval(substr($pegawai['kdkawin'], 1, 1));
        $anak = intval(substr($pegawai['kdkawin'], 2, 2));
        $jumlah_anggota = $ybs + $istri + $anak + $pegawai['art'];
        if ($pegawai['infant'] == 0) {
            $jumlah_anggota_pesawat = $jumlah_anggota;
        } else {
            $jumlah_anggota_pesawat = $jumlah_anggota - 1 + ($pegawai['infant'] * 0.1);
        }
        // -- selesai hitung
        $jumlah_kubik = $pegawai['kubik'];
        // menangkap data kota tujuan untuk mencari data uang harian di tiap provinsi
        $rute = $this->rute->getDetailRute($pegawai['ref_rute_id']);
        $tujuan = $rute['tujuan'];
        // tarik data tarif darat untuk tarif angkutan orang (2000) dan angkutan barang (400)
        $tarif_darat = $this->tarif_darat->getDetailTarifDarat(1);
        $tarif_orang = $tarif_darat['orang'];
        $tarif_barang = $tarif_darat['barang'];
        // tarik data packing
        $packing_darat = $this->packing->getDetailPacking(1)['jumlah'];
        $packing_laut = $this->packing->getDetailPacking(2)['jumlah'];
        $packing_udara = $this->packing->getDetailPacking(3)['jumlah'];
        $koefisien_packing = 1;

        // hitung biaya angkutan sesuai jenis angkutan sesuai tabel subrute
        $subrute = $this->subrute->getRefRute($ref_rute_id);
        foreach ($subrute as $r) {
            $subrute_id = $r['id'];
            $jenis_id = $r['jenis_id'];
            $angkutan_id = $r['angkutan_id'];
            $ref_id = $r['ref_id'];
            // hitung tarif tiap jenis angkutan
            switch ($angkutan_id) {
                case '1':
                    $pesawat = $this->subrute->getRefSubRute(1, $ref_id);
                    $data = [
                        'subrute_id' => $subrute_id,
                        'jenis_id' => $jenis_id,
                        'angkutan_id' => $angkutan_id,
                        'satuan' => $jumlah_anggota_pesawat,
                        'jarak' => '',
                        'tarif' => $pesawat['jumlah'],
                        'jumlah' => $jumlah_anggota_pesawat * $pesawat['jumlah'],
                        'pegawai_id' => $pegawai_id,
                        'uraian' => $pesawat['kota_asal'] . '-' . $pesawat['kota_tujuan']
                    ];
                    $this->biaya->createBiaya($data);
                    break;
                case '2':
                    $bus = $this->subrute->getRefSubRute(2, $ref_id);
                    $data = [
                        'subrute_id' => $subrute_id,
                        'jenis_id' => $jenis_id,
                        'angkutan_id' => $angkutan_id,
                        'satuan' => $jumlah_anggota_pesawat,
                        'jarak' => $bus['jumlah'],
                        'tarif' => $tarif_orang,
                        'jumlah' => $jumlah_anggota_pesawat * $bus['jumlah'] * $tarif_orang,
                        'pegawai_id' => $pegawai_id,
                        'uraian' => $bus['kota_asal'] . '-' . $bus['kota_tujuan']
                    ];
                    $this->biaya->createBiaya($data);
                    break;
                case '3':
                    $truk = $this->subrute->getRefSubRute(3, $ref_id);
                    // cek tarif apakah berlaku 50% apa 100%
                    // jika di pulau jawa, jarak dibawah 50km berlaku 50%, diatas 50km berlaku 100%
                    // jika di luar jawa, jarak dibawah 100km berlaku 50%, diatas 100km berlaku 100%
                    if ($truk['sts'] == '1' and $truk['jumlah'] <= 50) {
                        $tarif = $tarif_barang * 0.5;
                    } else if ($truk['sts'] == '2' and $truk['jumlah'] <= 100) {
                        $tarif = $tarif_barang * 0.5;
                    } else {
                        $tarif = $tarif_barang;
                    }
                    $data = [
                        'subrute_id' => $subrute_id,
                        'jenis_id' => $jenis_id,
                        'angkutan_id' => $angkutan_id,
                        'satuan' => $jumlah_kubik,
                        'jarak' => $truk['jumlah'],
                        'tarif' => $tarif,
                        'jumlah' => $jumlah_kubik * $truk['jumlah'] * $tarif,
                        'pegawai_id' => $pegawai_id,
                        'uraian' => $truk['kota_asal'] . '-' . $truk['kota_tujuan']
                    ];
                    $this->biaya->createBiaya($data);
                    break;
                case '4':
                    $kapal = $this->subrute->getRefSubRute(4, $ref_id);
                    $data = [
                        'subrute_id' => $subrute_id,
                        'jenis_id' => $jenis_id,
                        'angkutan_id' => $angkutan_id,
                        'satuan' => $jumlah_kubik,
                        'jarak' => '',
                        'tarif' => $kapal['jumlah'],
                        'jumlah' => $jumlah_kubik * $kapal['jumlah'],
                        'pegawai_id' => $pegawai_id,
                        'uraian' => $kapal['kota_asal'] . '-' . $kapal['kota_tujuan']
                    ];
                    $this->biaya->createBiaya($data);
                    break;
                case '5':
                    // cek tarif apakah berlaku 50% apa 100%
                    // jika di pulau jawa, jarak dibawah 50km berlaku 50%, diatas 50km berlaku 100%
                    // jika di luar jawa, jarak dibawah 100km berlaku 50%, diatas 100km berlaku 100%
                    $truk = $this->subrute->getRefSubRute(3, $ref_id);
                    if ($truk) {
                        if ($truk['sts'] == '1' and $truk['jumlah'] <= 50) {
                            $koefisien_packing = $koefisien_packing * 0.5;
                        } else if ($truk['sts'] == '2' and $truk['jumlah'] <= 100) {
                            $koefisien_packing = $koefisien_packing * 0.5;
                        } else {
                            $koefisien_packing = $koefisien_packing;
                        }
                    }
                    $packing = $this->subrute->getRefSubRute(5, $ref_id);
                    $data = [
                        'subrute_id' => $subrute_id,
                        'jenis_id' => $jenis_id,
                        'angkutan_id' => $angkutan_id,
                        'satuan' => $jumlah_kubik,
                        'jarak' => '',
                        'tarif' => $packing['jumlah'] * $koefisien_packing,
                        'jumlah' => $jumlah_kubik * $packing['jumlah'] * $koefisien_packing,
                        'pegawai_id' => $pegawai_id,
                        'uraian' => $packing['kota_asal'] . '-' . $packing['kota_tujuan']
                    ];
                    $this->biaya->createBiaya($data);
                    break;
            }
        }
        // hitung uang harian
        // cari data provinsi memakai data kota tujuan
        $provinsi = $this->provinsi->findProvinsi($tujuan, null, 0)[0]['provinsi'];
        // cari data uang harian memakai data provinsi
        $uang_harian = $this->uang_harian->findUangHarian($provinsi, null, 0)[0]['luar_kota'];
        $data = [
            'subrute_id' => 0,
            'jenis_id' => 3,
            'angkutan_id' => 6,
            'satuan' => $jumlah_anggota,
            'jarak' => 3,
            'tarif' => $uang_harian,
            'jumlah' => $jumlah_anggota * $uang_harian * 3,
            'pegawai_id' => $pegawai_id,
            'uraian' => 'UANG HARIAN'
        ];
        $this->biaya->createBiaya($data);
        // jika berhasil hitung
        // update nominal pada data pegawai
        $nominal = $this->biaya->getSumBiaya($pegawai_id)['jumlah'];
        $this->pegawai->updatePegawai(['nominal' => $nominal], $pegawai_id);
        // rekam data_timeline
        // cek apakah sudah ada data apa belum
        $proses_id = '4';
        $data_timeline = [
            'pegawai_id' => $pegawai_id,
            'proses_id' => $proses_id,
            'keterangan' => 'Kantor Pusat telah melakukan proses perhitungan biaya mutasi',
            'tanggal' => time()
        ];
        if ($this->timeline->cekTimeline($pegawai_id, $proses_id)) {
            $this->timeline->updateTimeline($data_timeline, $pegawai_id, $proses_id);
        } else {
            $this->timeline->createTimeline($data_timeline);
        }
        // selesai
        $this->session->set_flashdata('pesan', 'Data berhasil dihitung.');
        redirect('biaya-mutasi/detail/' . $sk_id);
    }

    public function hapus($pegawai_id = null, $ref_rute_id = null, $sk_id = null)
    {
        // cek apakah ada sk id apa tidak
        if (!isset($pegawai_id)) show_404();
        if (!isset($ref_rute_id)) show_404();
        if (!isset($sk_id)) show_404();

        // hapus data biaya
        $this->biaya->deleteBiayaPegawai($pegawai_id);
        // ubah nominal di data pegawai menjadi 0
        $this->pegawai->updatePegawai(['nominal' => 0], $pegawai_id);
        $this->session->set_flashdata('pesan', 'Data biaya berhasil dihapus.');
        redirect('biaya-mutasi/detail/' . $sk_id);
    }

    public function rincian($pegawai_id = null, $ref_rute_id = null, $sk_id = null)
    {
        // cek apakah ada sk id apa tidak
        if (!isset($pegawai_id)) show_404();
        if (!isset($ref_rute_id)) show_404();
        if (!isset($sk_id)) show_404();

        // ambil data biaya
        $data['sk_id'] = $sk_id;
        $data['biaya'] = $this->biaya->getRincianBiaya($pegawai_id);
        // meload view pada pegawai/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('biaya_mutasi/rincian', $data);
        $this->load->view('template/footer');
    }

    public function dnp($sk_id = null)
    {
        // cek apakah ada sk id apa tidak
        if (!isset($sk_id)) show_404();

        $data['ppk'] = $this->pejabat->getKodePejabat(1);
        $data['bendahara'] = $this->pejabat->getKodePejabat(2);
        $data['biaya_pegawai'] = $this->biaya_pegawai->getBiayaPegawai($sk_id);

        ob_start();
        $this->load->view('biaya_mutasi/dnp', $data);
        $html = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(20, 10, 20, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('DNP');
        $html2pdf->writeHTML($html);
        $html2pdf->output('dnp-' . $sk_id . '.pdf', 'D');
    }

    public function excel($sk_id = null)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'no');
        $sheet->setCellValue('B1', 'nip');
        $sheet->setCellValue('C1', 'nama');
        $sheet->setCellValue('D1', 'gol');
        $sheet->setCellValue('E1', 'rekening');
        $sheet->setCellValue('F1', 'asal');
        $sheet->setCellValue('G1', 'tujuan');
        $sheet->setCellValue('H1', 'jml_pegawai');
        $sheet->setCellValue('I1', 'jml_barang');
        $sheet->setCellValue('J1', 'jml_lumpsum');
        $sheet->setCellValue('K1', 'jml_total');

        $biaya_pegawai = $this->biaya_pegawai->getBiayaPegawai($sk_id);

        $no = 1;
        $i = 2;
        foreach ($biaya_pegawai as $r) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, ' ' . $r['nip']);
            $sheet->setCellValue('C' . $i, $r['nmpeg']);
            $sheet->setCellValue('D' . $i, substr($r['kdgapok'], 0, 2));
            $sheet->setCellValue('E' . $i, $r['rekening']);
            $sheet->setCellValue('F' . $i, $r['asal']);
            $sheet->setCellValue('G' . $i, $r['tujuan']);
            $sheet->setCellValue('H' . $i, $r['jml_jenis1']);
            $sheet->setCellValue('I' . $i, $r['jml_jenis2']);
            $sheet->setCellValue('J' . $i, $r['jml_jenis3']);
            $sheet->setCellValue('K' . $i, $r['jml_total']);
            $i++;
        }

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $i = $i - 1;
        $sheet->getStyle('A1:K' . $i)->applyFromArray($styleArray);

        // simpan datanya
        $date = date('d-m-y-' . substr((string)microtime(), 1, 8));
        $date = str_replace(".", "", $date);
        $filename = "excel_" . $date . ".xlsx";
        try {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save($filename);
            $content = file_get_contents($filename);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
        header("Content-Disposition: attachment; filename=" . $filename);
        unlink($filename);
        exit($content);
    }
}
