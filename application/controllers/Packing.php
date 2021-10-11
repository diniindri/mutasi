<?php

use Spipu\Html2Pdf\Html2Pdf;

class Packing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        // meload file ref_kapal_model.php
        $this->load->model('Ref_packing_model', 'packing');
    }

    public function index()
    {
        $data['packing'] = $this->packing->getPacking(null, 0);

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
            'label' => 'Uraian',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'kota_tujuan',
            'label' => 'Jenis',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'jumlah',
            'label' => 'Jumlah',
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
