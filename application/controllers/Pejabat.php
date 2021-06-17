<?php

use Spipu\Html2Pdf\Html2Pdf;

class Pejabat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // meload file ref_pejabat_model.php
        $this->load->model('Ref_pejabat_model', 'pejabat');
    }

    public function index()
    {
        // menangkap data pencarian nama pejabat
        $nama = $this->input->post('nama');

        // settingan halaman
        $config['base_url'] = base_url('pejabat/index');
        $config['total_rows'] = $this->pejabat->countPejabat();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['nama'] = $nama;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian nama pejabat
        if ($nama) {
            $data['page'] = 0;
            $offset = 0;
            $data['pejabat'] = $this->pejabat->findPejabat($nama, $limit, $offset);
        } else {
            $data['pejabat'] = $this->pejabat->getPejabat($limit, $offset);
        }

        // meload view pada pejabat/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pejabat/index', $data);
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
            'field' => 'nip',
            'label' => 'NIP',
            'rules' => 'required|trim|exact_length[18]'
        ],
        [
            'field' => 'nama',
            'label' => 'Nama',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'jabatan',
            'label' => 'jabatan',
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
                'nip' => htmlspecialchars($this->input->post('nip', true)),
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'jabatan' => htmlspecialchars($this->input->post('jabatan', true))
            ];
            // simpan data ke database melalui model
            $this->pejabat->createPejabat($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('pejabat');
        }

        // meload view pada pejabat/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pejabat/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data dokumen yang akan diubah
        $data['pejabat'] = $this->pejabat->getDetailPejabat($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'kode' => htmlspecialchars($this->input->post('kode', true)),
                'nip' => htmlspecialchars($this->input->post('nip', true)),
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'jabatan' => htmlspecialchars($this->input->post('jabatan', true))
            ];
            // update data di database melalui model
            $this->pejabat->updatePejabat($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('pejabat');
        }

        // meload view pada dokumen/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pejabat/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->pejabat->deletePejabat($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('pejabat');
    }
}
