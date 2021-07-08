<?php

class Tarif_darat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // meload file ref_tarif_darat_model.php
        $this->load->model('Ref_tarif_darat_model', 'tarif_darat');
    }

    public function index()
    {
        $data['tarif_darat'] = $this->tarif_darat->getTarifDarat(null, 0);

        // meload view pada tarif_darat/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('tarif_darat/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada form
    private $rules = [
        [
            'field' => 'orang',
            'label' => 'Orang',
            'rules' => 'required|trim|numeric'
        ],
        [
            'field' => 'barang',
            'label' => 'Barang',
            'rules' => 'required|trim|numeric'
        ],
    ];

    public function create()
    {
        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'orang' => htmlspecialchars($this->input->post('orang', true)),
                'barang' => htmlspecialchars($this->input->post('barang', true))
            ];
            // simpan data ke database melalui model
            $this->tarif_darat->createTarifDarat($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('tarif_darat');
        }

        // meload view pada tarif_darat/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('tarif_darat/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data kubik yang akan diubah
        $data['tarif_darat'] = $this->tarif_darat->getDetailTarifDarat($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'orang' => htmlspecialchars($this->input->post('orang', true)),
                'barang' => htmlspecialchars($this->input->post('barang', true))
            ];
            // update data di database melalui model
            $this->tarif_darat->updateTarifDarat($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('tarif_darat');
        }

        // meload view pada tarif_darat/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('tarif_darat/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->tarif_darat->deleteTarifDarat($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('tarif_darat');
    }
}
