<?php

use Spipu\Html2Pdf\Html2Pdf;

class Timeline extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('View_pegawai_sk_model', 'view_pegawai_sk');
        $this->load->model('Data_timeline_model', 'timeline');
    }

    public function index($pegawai_id = null)
    {
        $nip = $this->session->userdata('nip');
        $data['sk'] = $this->view_pegawai_sk->getPegawaiSk($nip);
        if (!isset($pegawai_id)) {
            $data['timeline'] = [];
        } else {
            $data['timeline'] = $this->timeline->getTimeline($pegawai_id);
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('timeline/index', $data);
        $this->load->view('template/footer');
    }
}
