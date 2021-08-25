<?php

use Spipu\Html2Pdf\Html2Pdf;

class Proses extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // meload file ref_jenis_model.php
        $this->load->model('Ref_proses_model', 'proses');
    }

    public function index()
    {
        // menangkap data pencarian nama jenis
        $nama = $this->input->post('nama');

        // settingan halaman
        $config['base_url'] = base_url('proses/index');
        $config['total_rows'] = $this->proses->countProses();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['nama'] = $nama;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian nama jenis
        if ($nama) {
            $data['page'] = 0;
            $offset = 0;
            $data['proses'] = $this->proses->findProses($nama, $limit, $offset);
        } else {
            $data['proses'] = $this->proses->getproses($limit, $offset);
        }

        // meload view pada jenis/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('proses/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada form
    private $rules = [
        [
            'field' => 'nama',
            'label' => 'Nama',
            'rules' => 'required|trim'
        ]
    ];

    public function create()
    {
        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true))
            ];
            // simpan data ke database melalui model
            $this->proses->createProses($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('proses');
        }

        // meload view pada jenis/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('proses/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data jenis yang akan diubah
        $data['proses'] = $this->proses->getDetailProses($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true))
            ];
            // update data di database melalui model
            $this->proses->updateProses($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('proses');
        }

        // meload view pada jenis/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('proses/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->proses->deleteProses($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('proses');
    }
}
