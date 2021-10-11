<?php

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
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
            'field' => 'tahun_anggaran',
            'label' => 'Tahun',
            'rules' => 'required|trim|exact_length[4]'
        ],
        [
            'field' => 'nomor_spd',
            'label' => 'SPD',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'akun',
            'label' => 'Akun',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'dipa_kantor',
            'label' => 'DIPA',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'kota',
            'label' => 'Kota',
            'rules' => 'required|trim'
        ],
    ];

    public function create()
    {
        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'tahun_anggaran' => htmlspecialchars($this->input->post('tahun_anggaran', true)),
                'nomor_spd' => htmlspecialchars($this->input->post('nomor_spd', true)),
                'akun' => htmlspecialchars($this->input->post('akun', true)),
                'dipa_kantor' => htmlspecialchars($this->input->post('dipa_kantor', true)),
                'kota' => htmlspecialchars($this->input->post('kota', true))
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
                'tahun_anggaran' => htmlspecialchars($this->input->post('tahun_anggaran', true)),
                'nomor_spd' => htmlspecialchars($this->input->post('nomor_spd', true)),
                'akun' => htmlspecialchars($this->input->post('akun', true)),
                'dipa_kantor' => htmlspecialchars($this->input->post('dipa_kantor', true)),
                'kota' => htmlspecialchars($this->input->post('kota', true))
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
