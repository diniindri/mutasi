<?php

use Spipu\Html2Pdf\Html2Pdf;

class Jenis extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        // meload file ref_jenis_model.php
        $this->load->model('Ref_jenis_model', 'jenis');
    }

    public function index()
    {
        // menangkap data pencarian nama jenis
        $nama = $this->input->post('nama');

        // settingan halaman
        $config['base_url'] = base_url('jenis/index');
        $config['total_rows'] = $this->jenis->countJenis();
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
            $data['jenis'] = $this->jenis->findJenis($nama, $limit, $offset);
        } else {
            $data['jenis'] = $this->jenis->getJenis($limit, $offset);
        }

        // meload view pada jenis/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('jenis/index', $data);
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
            $this->jenis->createJenis($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('jenis');
        }

        // meload view pada jenis/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('jenis/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data jenis yang akan diubah
        $data['jenis'] = $this->jenis->getDetailJenis($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true))
            ];
            // update data di database melalui model
            $this->jenis->updateJenis($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('jenis');
        }

        // meload view pada jenis/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('jenis/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->jenis->deleteJenis($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('jenis');
    }
}
