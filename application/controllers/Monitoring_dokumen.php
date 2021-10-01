<?php

use Spipu\Html2Pdf\Html2Pdf;

class Monitoring_dokumen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // meload file Data_sk_model.php
        $this->load->model('Data_sk_model', 'sk');
        $this->load->model('Data_upload_model', 'upload');
        $this->load->model('Data_pegawai_model', 'pegawai');
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
        $this->load->view('monitoring_dokumen/index', $data);
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
        $config['base_url'] = base_url('monitoring-dokumen/detail/' . $sk_id . '');
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
        $this->load->view('monitoring_dokumen/detail', $data);
        $this->load->view('template/footer');
    }
}
