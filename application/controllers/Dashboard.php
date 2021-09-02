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
    }

    public function index($pegawai_id = null)
    {
        $nip = $this->session->userdata('nip');
        $data['sk'] = $this->view_pegawai_sk->getPegawaiSk($nip);
        if (!isset($pegawai_id)) {
            $data['detail_sk'] = [
                'tanggal' => '',
                'uraian' => '',
                'asal' => '',
                'tujuan' => ''
            ];
            $data['biaya'] = [];
        } else {
            $data['detail_sk'] = $this->view_pegawai_sk->getDetailPegawaiSk($pegawai_id);
            $data['biaya'] = $this->biaya->getRincianBiaya($pegawai_id);
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('template/footer');
    }

    public function detail($sk_id = null)
    {
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/detail');
        $this->load->view('template/footer');
    }
}
