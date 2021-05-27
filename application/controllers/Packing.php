<?php

use Spipu\Html2Pdf\Html2Pdf;

class Packing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // meload file ref_kapal_model.php
        $this->load->model('Ref_packing_model', 'packing');
    }

    public function index()
    {
        // menangkap data pencarian Jenis Packing
        $tujuan = $this->input->post('tujuan');

        // settingan halaman
        $config['base_url'] = base_url('packing/index');
        $config['total_rows'] = $this->packing->countPacking();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['tujuan'] = $tujuan;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian jenis packing
        if ($tujuan) {
            $data['page'] = 0;
            $offset = 0;
            $data['packing'] = $this->packing->findPacking($tujuan, $limit, $offset);
        } else {
            $data['packing'] = $this->packing->getPacking($limit, $offset);
        }

        // meload view pada packing/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('packing/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada form
    private $rules = [
        [
            'field' => 'kota_asal',
            'label' => 'Kota Asal',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'kota_tujuan',
            'label' => 'Kota Tujuan',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'jumlah',
            'label' => 'Nominal',
            'rules' => 'required|trim|numeric'
        ]
    ];

    public function create()
    {
        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'kota_asal' => htmlspecialchars($this->input->post('kota_asal', true)),
                'kota_tujuan' => htmlspecialchars($this->input->post('kota_tujuan', true)),
                'jumlah' => htmlspecialchars($this->input->post('jumlah', true))
            ];
            // simpan data ke database melalui model
            $this->packing->createPacking($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('packing');
        }

        // meload view pada packing/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('packing/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data packing yang akan diubah
        $data['packing'] = $this->packing->getDetailPacking($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'kota_asal' => htmlspecialchars($this->input->post('kota_asal', true)),
                'kota_tujuan' => htmlspecialchars($this->input->post('kota_tujuan', true)),
                'jumlah' => htmlspecialchars($this->input->post('jumlah', true))
            ];
            // update data di database melalui model
            $this->packing->updatePacking($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('packing');
        }

        // meload view pada packing/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('packing/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->packing->deletePacking($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('packing');
    }
}
