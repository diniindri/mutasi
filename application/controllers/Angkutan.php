<?php

use Spipu\Html2Pdf\Html2Pdf;

class Angkutan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        // meload file ref_angkutan_model.php
        $this->load->model('Ref_angkutan_model', 'angkutan');
    }

    public function index()
    {
        // menangkap data pencarian nama jenis
        $nama = $this->input->post('nama');

        // settingan halaman
        $config['base_url'] = base_url('angkutan/index');
        $config['total_rows'] = $this->angkutan->countAngkutan();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['nama'] = $nama;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian nama angkutan
        if ($nama) {
            $data['page'] = 0;
            $offset = 0;
            $data['angkutan'] = $this->angkutan->findAngkutan($nama, $limit, $offset);
        } else {
            $data['angkutan'] = $this->angkutan->getAngkutan($limit, $offset);
        }

        // meload view pada angkutan/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('angkutan/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada form
    private $rules = [
        [
            'field' => 'nama',
            'label' => 'Nama',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'icon',
            'label' => 'Icon',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'jenis_id',
            'label' => 'Jenis',
            'rules' => 'required|trim'
        ]
    ];

    public function create()
    {
        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'icon' => htmlspecialchars($this->input->post('icon', true)),
                'jenis_id' => htmlspecialchars($this->input->post('jenis_id', true))
            ];
            // simpan data ke database melalui model
            $this->angkutan->createAngkutan($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('angkutan');
        }

        // meload view pada angkutan/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('angkutan/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data jenis yang akan diubah
        $data['angkutan'] = $this->angkutan->getDetailAngkutan($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'icon' => htmlspecialchars($this->input->post('icon', true)),
                'jenis_id' => htmlspecialchars($this->input->post('jenis_id', true))
            ];
            // update data di database melalui model
            $this->angkutan->updateAngkutan($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('angkutan');
        }

        // meload view pada angkutan/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('angkutan/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->angkutan->deleteAngkutan($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('angkutan');
    }
}
