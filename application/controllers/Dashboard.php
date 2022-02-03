<?php

use Spipu\Html2Pdf\Html2Pdf;

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Data_biaya_model', 'biaya');
        $this->load->model('Data_pegawai_model', 'pegawai');
        $this->load->model('Data_keluarga_model', 'keluarga');
        $this->load->model('Data_upload_model', 'data_upload');
        $this->load->model('Ref_dokumen_model', 'dokumen');
        $this->load->model('Ref_pejabat_model', 'pejabat');
        $this->load->model('Ref_laporan_model', 'laporan');
        $this->load->model('Data_timeline_model', 'timeline');
        $this->load->model('View_pegawai_sk_model', 'pegawai_sk');
    }

    public function index($pegawai_id = null)
    {
        $nip = $this->session->userdata('nip');
        $data['sk'] = $this->pegawai_sk->getPegawaiSk($nip);

        if (!isset($pegawai_id) && $data['sk']) $pegawai_id = $data['sk'][0]['pegawai_id'];

        $nip_sk = $this->pegawai_sk->getDetailPegawaiSk($pegawai_id);
        $nip_sk ? $nip_sk = $nip_sk['nip'] : $nip_sk = '';
        if (!isset($pegawai_id) || $nip <> $nip_sk) {
            $data['pegawai_id'] = null;
            $data['detail_sk'] = [
                'tanggal' => '',
                'uraian' => '',
                'asal' => '',
                'tujuan' => ''
            ];
            $data['biaya'] = [];
            $data['upload'] = [];
            $data['download'] = [];
        } else {
            $data['pegawai_id'] = $pegawai_id;
            $data['detail_sk'] = $this->pegawai_sk->getDetailPegawaiSk($pegawai_id);
            $data['biaya'] = $this->biaya->getRincianBiaya($pegawai_id);
            $data['upload'] = $this->dokumen->getAllDokumen();
            $data['download'] = [
                ['nama' => 'KP4 <small>(download via alika.kemenkeu.go.id)</small>', 'url' => 'https://alika.kemenkeu.go.id/beranda'],
                ['nama' => 'Rincian Biaya', 'url' => '' . base_url() . 'dashboard/download-biaya/' . $pegawai_id . ''],
                ['nama' => 'SPD', 'url' => '' . base_url() . 'dashboard/download-spd/' . $pegawai_id . '']
            ];
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('template/footer');
    }

    public function upload($pegawai_id = null, $kode = null)
    {
        if (!isset($kode)) show_404();
        $data['pegawai_id'] = $pegawai_id;

        $validation = $this->form_validation->set_rules('file', 'File', 'trim');
        if ($validation->run() && $_FILES) {
            //upload file pdf
            $upload_file = $_FILES['file']['name'];
            if ($upload_file) {
                $config['allowed_types'] = 'pdf';
                $config['remove_spaces'] = TRUE;
                $config['max_size']     = '10000';
                $config['encrypt_name']     = TRUE;
                $config['upload_path'] = 'assets/files/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $new_file = $this->upload->data('file_name');
                    $this->db->set('file', $new_file);
                    //simpan data ke tabel data_upload
                    $data = [
                        'pegawai_id' => $pegawai_id,
                        'kode' => $kode,
                        'date_created' => time()
                    ];
                    $this->data_upload->createUpload($data);
                    // rekam data_timeline
                    // cek apakah sudah ada data apa belum
                    switch ($kode) {
                        case '1':
                            $proses_id = '2';
                            $keterangan = 'Pegawai telah melakukan upload dokumen KP4 yang sudah disahkan oleh Pejabat yang berwenang';
                            break;
                        case '2':
                            $proses_id = '5';
                            $keterangan = 'Pegawai telah melakukan upload dokumen rincian biaya mutasi yang sudah ditandatangani';
                            break;
                        case '3':
                            $proses_id = '6';
                            $keterangan = 'Pegawai telah melakukan upload dokumen SPD yang sudah ditandatangani oleh Pejabat yang berwenang pada Kantor asal';
                            break;
                        case '4':
                            $proses_id = '7';
                            $keterangan = 'Pegawai telah melakukan upload dokumen SPD yang sudah ditandatangani oleh Pejabat yang berwenang pada Kantor tujuan';
                            break;
                        default:
                            $proses_id = '11';
                            $keterangan = 'Pegawai telah melakukan upload dokumen KTP ART';
                            break;
                    }

                    $data_timeline = [
                        'pegawai_id' => $pegawai_id,
                        'proses_id' => $proses_id,
                        'keterangan' => $keterangan,
                        'tanggal' => time()
                    ];
                    if ($this->timeline->cekTimeline($pegawai_id, $proses_id)) {
                        $this->timeline->updateTimeline($data_timeline, $pegawai_id, $proses_id);
                    } else {
                        $this->timeline->createTimeline($data_timeline);
                    }
                    // selesai
                    redirect('dashboard/index/' . $pegawai_id . '');
                } else {
                    echo $this->upload->display_errors();
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Upload file gagal, mohon menggunakan format file pdf dan ukuran maksimal 10 MB!</div>');
                    redirect('dashboard/upload/' . $pegawai_id . '/' . $kode . '');
                }
            }
        }

        // form
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/upload', $data);
        $this->load->view('template/footer');
    }

    public function download_spd($pegawai_id = null)
    {
        $nip = $this->session->userdata('nip');

        $data['ppk'] = $this->pejabat->getKodePejabat(1);
        $data['pegawai'] = $this->pegawai->getDetailPegawai($pegawai_id);
        $data['keluarga'] = $this->keluarga->getKeluarga($pegawai_id);
        $data['detail_sk'] = $this->pegawai_sk->getDetailPegawaiSk($pegawai_id);
        $data['laporan'] = $this->laporan->getDetailLaporan(1);
        ob_start();
        $this->load->view('dashboard/spd', $data);
        $html = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(20, 10, 20, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('SPD');
        $html2pdf->writeHTML($html);
        $html2pdf->output('spd-' . $nip . '.pdf', 'D');
    }

    public function download_biaya($pegawai_id = null)
    {
        $nip = $this->session->userdata('nip');

        $data['ppk'] = $this->pejabat->getKodePejabat(1);
        $data['bendahara'] = $this->pejabat->getKodePejabat(2);
        $data['pegawai'] = $this->pegawai->getDetailPegawai($pegawai_id);
        $data['laporan'] = $this->laporan->getDetailLaporan(1);
        $data['biaya_orang'] = $this->biaya->getRincianBiayaPerJenis($pegawai_id, 1);
        $data['biaya_barang'] = $this->biaya->getRincianBiayaPerJenis($pegawai_id, 2);
        $data['biaya_lumpsum'] = $this->biaya->getRincianBiayaPerJenis($pegawai_id, 3);
        ob_start();
        $this->load->view('dashboard/biaya', $data);
        $html = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(20, 10, 20, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Biaya');
        $html2pdf->writeHTML($html);
        $html2pdf->output('biaya-' . $nip . '.pdf', 'D');
    }
}
