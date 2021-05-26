<?php

use Spipu\Html2Pdf\Html2Pdf;

class Uang_harian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // meload file ref_uang_harian_model.php
        $this->load->model('Ref_uang_harian_model', 'uang_harian');
    }

    public function index()
    {
        // menangkap data pencarian provinsi uang harian
        $provinsi = $this->input->post('provinsi');

        // settingan halaman
        $config['base_url'] = base_url('uang_harian/index');
        $config['total_rows'] = $this->uang_harian->countUangHarian();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['provinsi'] = $provinsi;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian golongan kubik
        if ($provinsi) {
            $data['page'] = 0;
            $offset = 0;
            $data['uang_harian'] = $this->uang_harian->findUangHarian($provinsi, $limit, $offset);
        } else {
            $data['uang_harian'] = $this->uang_harian->getUangHarian($limit, $offset);
        }

        // meload view pada uang_harian/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('uang_harian/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada form
    private $rules = [
        [
            'field' => 'provinsi',
            'label' => 'Provinsi',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'luar_kota',
            'label' => 'Luar Kota',
            'rules' => 'required|trim|numeric'
        ],
        [
            'field' => 'dalam_kota',
            'label' => 'Dalam Kota',
            'rules' => 'required|trim|numeric'
        ],
        [
            'field' => 'diklat',
            'label' => 'Diklat',
            'rules' => 'required|trim|numeric'
        ]
    ];

    public function create()
    {
        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'provinsi' => htmlspecialchars($this->input->post('provinsi', true)),
                'luar_kota' => htmlspecialchars($this->input->post('luar_kota', true)),
                'dalam_kota' => htmlspecialchars($this->input->post('dalam_kota', true)),
                'diklat' => htmlspecialchars($this->input->post('diklat', true))
            ];
            // simpan data ke database melalui model
            $this->uang_harian->createUangHarian($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('uang_harian');
        }

        // meload view pada uang_harian/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('uang_harian/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data kubik yang akan diubah
        $data['uang_harian'] = $this->uang_harian->getUangHarian($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'provinsi' => htmlspecialchars($this->input->post('provinsi', true)),
                'luar_kota' => htmlspecialchars($this->input->post('luar_kota', true)),
                'dalam_kota' => htmlspecialchars($this->input->post('dalam_kota', true)),
                'diklat' => htmlspecialchars($this->input->post('diklat', true))
            ];
            // update data di database melalui model
            $this->uang_harian->updateUangHarian($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('uang_harian');
        }

        // meload view pada uang_harian/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('uang_harian/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->uang_harian->deleteUangharian($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('uang_harian');
    }
}
