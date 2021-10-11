<?php

use Spipu\Html2Pdf\Html2Pdf;

class Dokumen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        // meload file ref_dokumen_model.php
        $this->load->model('Ref_dokumen_model', 'dokumen');
    }

    public function index()
    {
        // menangkap data pencarian jenis dokumen
        $jenis = $this->input->post('jenis');

        // settingan halaman
        $config['base_url'] = base_url('dokumen/index');
        $config['total_rows'] = $this->dokumen->countDokumen();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['jenis'] = $jenis;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian jenis dokumen
        if ($jenis) {
            $data['page'] = 0;
            $offset = 0;
            $data['dokumen'] = $this->dokumen->findDokumen($jenis, $limit, $offset);
        } else {
            $data['dokumen'] = $this->dokumen->getDokumen($limit, $offset);
        }

        // meload view pada dokumen/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('dokumen/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada form
    private $rules = [
        [
            'field' => 'kode',
            'label' => 'Kode',
            'rules' => 'required|trim|numeric'
        ],
        [
            'field' => 'jenis',
            'label' => 'Jenis',
            'rules' => 'required|trim'
        ],
    ];

    public function create()
    {
        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'kode' => htmlspecialchars($this->input->post('kode', true)),
                'jenis' => htmlspecialchars($this->input->post('jenis', true))
            ];
            // simpan data ke database melalui model
            $this->dokumen->createDokumen($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('dokumen');
        }

        // meload view pada dokumen/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('dokumen/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data dokumen yang akan diubah
        $data['dokumen'] = $this->dokumen->getDetailDokumen($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'kode' => htmlspecialchars($this->input->post('kode', true)),
                'jenis' => htmlspecialchars($this->input->post('jenis', true))
            ];
            // update data di database melalui model
            $this->dokumen->updateDokumen($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('dokumen');
        }

        // meload view pada dokumen/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('dokumen/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->dokumen->deleteDokumen($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('dokumen');
    }
}
