<?php

use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Spipu\Html2Pdf\Html2Pdf;

class Provinsi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        // meload file ref_provinsi_model.php
        $this->load->model('Ref_provinsi_model', 'provinsi');
    }

    public function index()
    {
        // menangkap data pencarian tujuan provinsi
        $tujuan = $this->input->post('tujuan');

        // settingan halaman
        $config['base_url'] = base_url('provinsi/index');
        $config['total_rows'] = $this->provinsi->countProvinsi();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['tujuan'] = $tujuan;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian tujuan provinsi
        if ($tujuan) {
            $data['page'] = 0;
            $offset = 0;
            $data['provinsi'] = $this->provinsi->findProvinsi($tujuan, $limit, $offset);
        } else {
            $data['provinsi'] = $this->provinsi->getProvinsi($limit, $offset);
        }

        // meload view pada provinsi/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('provinsi/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada form
    private $rules = [
        [
            'field' => 'tujuan',
            'label' => 'Kota Tujuan',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'provinsi',
            'label' => 'Provinsi',
            'rules' => 'required|trim'
        ]
    ];

    public function create()
    {

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'tujuan' => htmlspecialchars($this->input->post('tujuan', true)),
                'provinsi' => htmlspecialchars($this->input->post('provinsi', true))
            ];
            // simpan data ke database melalui model
            $this->provinsi->createProvinsi($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('provinsi');
        }

        // meload view pada provinsi/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('provinsi/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data provinsi yang akan diubah
        $data['provinsi'] = $this->provinsi->getDetailProvinsi($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'tujuan' => htmlspecialchars($this->input->post('tujuan', true)),
                'provinsi' => htmlspecialchars($this->input->post('provinsi', true))
            ];
            // update data di database melalui model
            $this->provinsi->updateProvinsi($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('provinsi');
        }

        // meload view pada provinsi/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('provinsi/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->provinsi->deleteProvinsi($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('provinsi');
    }
}
