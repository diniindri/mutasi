<?php

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Ref_laporan_model', 'laporan');
    }

    public function index()
    {
        // menangkap data pencarian nama laporan
        $nama = $this->input->post('nama');

        // settingan halaman
        $config['base_url'] = base_url('laporan/index');
        $config['total_rows'] = $this->laporan->countLaporan();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['nama'] = $nama;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian nama laporan
        if ($nama) {
            $data['page'] = 0;
            $offset = 0;
            $data['laporan'] = $this->laporan->findLaporan($nama, $limit, $offset);
        } else {
            $data['laporan'] = $this->laporan->getLaporan($limit, $offset);
        }

        // meload view pada laporan/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('laporan/index', $data);
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
            $this->laporan->createLaporan($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('laporan');
        }

        // meload view pada laporan/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('laporan/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data dokumen yang akan diubah
        $data['laporan'] = $this->laporan->getDetailLaporan($id);

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
            $this->laporan->updateLaporan($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('laporan');
        }

        // meload view pada dokumen/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('laporan/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->laporan->deleteLaporan($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('laporan');
    }
}
