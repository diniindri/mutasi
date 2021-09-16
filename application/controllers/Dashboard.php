<?php

use Spipu\Html2Pdf\Html2Pdf;

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('View_pegawai_sk_model', 'view_pegawai_sk');
        $this->load->model('Data_biaya_model', 'biaya');
        $this->load->model('Data_upload_model', 'data_upload');
        $this->load->model('Ref_dokumen_model', 'dokumen');
    }

    public function index($pegawai_id = null)
    {
        $nip = $this->session->userdata('nip');
        $data['sk'] = $this->view_pegawai_sk->getPegawaiSk($nip);
        if (!isset($pegawai_id)) {
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
            $data['detail_sk'] = $this->view_pegawai_sk->getDetailPegawaiSk($pegawai_id);
            $data['biaya'] = $this->biaya->getRincianBiaya($pegawai_id);
            $data['upload'] = $this->dokumen->getAllDokumen();
            $data['download'] = [
                ['nama' => 'KP4 <small>(download via alika.kemenkeu.go.id)</small>', 'url' => 'https://alika.kemenkeu.go.id'],
                ['nama' => 'Rincian Biaya', 'url' => ''],
                ['nama' => 'SPD', 'url' => '']
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
}
