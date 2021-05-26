<?php

use Spipu\Html2Pdf\Html2Pdf;

class Bus_truk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // meload file ref_darat_model.php
        $this->load->model('Ref_darat_model', 'darat');
    }

    public function index()
    {
        // menangkap data pencarian asal dan tujuan bus dan truk
        $asal = $this->input->post('asal');
        $tujuan = $this->input->post('tujuan');

        // settingan halaman
        $config['base_url'] = base_url('bus_truk/index');
        $config['total_rows'] = $this->darat->countDarat();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['asal'] = $asal;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian asal dan tujuan bus dan truk
        if ($asal) {
            $data['page'] = 0;
            $offset = 0;
            $data['darat'] = $this->darat->findDarat($asal, $tujuan, $limit, $offset);
        } else {
            $data['darat'] = $this->darat->getDarat($limit, $offset);
        }

        // meload view pada bus_truk/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('bus_truk/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada form
    private $rules = [
        [
            'field' => 'kota_asal',
            'label' => 'Kota Asal',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'kota_tujuan',
            'label' => 'Kota Tujuan',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'jumlah',
            'label' => 'Jumlah',
            'rules' => 'required|trim|numeric'
        ],
        [
            'field' => 'sts',
            'label' => 'Status',
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
                'jumlah' => htmlspecialchars($this->input->post('jumlah', true)),
                'sts' => htmlspecialchars($this->input->post('sts', true))
            ];
            // simpan data ke database melalui model
            $this->darat->createDarat($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('bus_truk');
        }

        // meload view pada bus_truk/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('bus_truk/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data bus dan truk yang akan diubah
        $data['darat'] = $this->darat->getDetailDarat($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'kota_asal' => htmlspecialchars($this->input->post('kota_asal', true)),
                'kota_tujuan' => htmlspecialchars($this->input->post('kota_tujuan', true)),
                'jumlah' => htmlspecialchars($this->input->post('jumlah', true)),
                'sts' => htmlspecialchars($this->input->post('sts', true))
            ];
            // update data di database melalui model
            $this->darat->updateDarat($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('bus_truk');
        }

        // meload view pada bus_truk/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('bus_truk/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->darat->deleteDarat($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('bus_truk');
    }
}
