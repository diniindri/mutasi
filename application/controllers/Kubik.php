<?php

use Spipu\Html2Pdf\Html2Pdf;

class Kubik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // meload file ref_kubik_model.php
        $this->load->model('Ref_kubik_model', 'kubik');
    }

    public function index()
    {
        // menangkap data pencarian golongan kubik
        $gol = $this->input->post('gol');

        // settingan halaman
        $config['base_url'] = base_url('kubik/index');
        $config['total_rows'] = $this->kubik->countKubik();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['gol'] = $gol;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian golongan kubik
        if ($gol) {
            $data['page'] = 0;
            $offset = 0;
            $data['kubik'] = $this->kubik->findKubik($gol, $limit, $offset);
        } else {
            $data['kubik'] = $this->kubik->getKubik($limit, $offset);
        }

        // meload view pada kubik/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('kubik/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada form
    private $rules = [
        [
            'field' => 'gol',
            'label' => 'Golongan',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'sts',
            'label' => 'status',
            'rules' => 'required|trim|numeric'
        ],
        [
            'field' => 'jml',
            'label' => 'Jumlah Anggota',
            'rules' => 'required|trim|numeric'
        ],
        [
            'field' => 'jumlah',
            'label' => 'Jumlah Kubik',
            'rules' => 'required|trim|numeric'
        ]
    ];

    public function create()
    {
        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'gol' => htmlspecialchars($this->input->post('gol', true)),
                'sts' => htmlspecialchars($this->input->post('sts', true)),
                'jml' => htmlspecialchars($this->input->post('jml', true)),
                'jumlah' => htmlspecialchars($this->input->post('jumlah', true))
            ];
            // simpan data ke database melalui model
            $this->kubik->createKubik($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('kubik');
        }

        // meload view pada kubik/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('kubik/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data kubik yang akan diubah
        $data['kubik'] = $this->kubik->getDetailKubik($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'gol' => htmlspecialchars($this->input->post('gol', true)),
                'sts' => htmlspecialchars($this->input->post('sts', true)),
                'jml' => htmlspecialchars($this->input->post('jml', true)),
                'jumlah' => htmlspecialchars($this->input->post('jumlah', true))
            ];
            // update data di database melalui model
            $this->kubik->updateKubik($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('kubik');
        }

        // meload view pada kubik/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('kubik/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->kubik->deleteKubik($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('kubik');
    }
}
