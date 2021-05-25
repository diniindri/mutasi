<?php

class Rute extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // meload file ref_rute_model.php
        $this->load->model('Ref_rute_model', 'rute');
        $this->load->model('Ref_sub_rute_model', 'subrute');
    }

    public function index()
    {
        // menangkap data pencarian asal dan tujuan rute
        $asal = $this->input->post('asal');
        $tujuan = $this->input->post('tujuan');

        // settingan halaman
        $config['base_url'] = base_url('rute/index');
        $config['total_rows'] = $this->rute->countRute();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['asal'] = $asal;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian asal dan tujuan rute
        if ($asal) {
            $data['page'] = 0;
            $offset = 0;
            $data['rute'] = $this->rute->findRute($asal, $tujuan, $limit, $offset);
        } else {
            $data['rute'] = $this->rute->getRute($limit, $offset);
        }

        // meload view pada rute/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('rute/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada seluruh form
    private $rules = [
        [
            'field' => 'asal',
            'label' => 'Asal',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'tujuan',
            'label' => 'Tujuan',
            'rules' => 'required|trim'
        ]
    ];

    public function create()
    {
        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'asal' => htmlspecialchars($this->input->post('asal', true)),
                'tujuan' => htmlspecialchars($this->input->post('tujuan', true)),
                'date_created' => time()
            ];
            // simpan data ke database melalui model
            $this->rute->createRute($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('rute');
        }

        // meload view pada rute/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('rute/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data rute yang akan diubah
        $data['rute'] = $this->rute->getDetailRute($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'asal' => htmlspecialchars($this->input->post('asal', true)),
                'tujuan' => htmlspecialchars($this->input->post('tujuan', true)),
                'date_created' => time()
            ];
            // update data di database melalui model
            $this->rute->updateRute($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('rute');
        }

        // meload view pada rute/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('rute/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->rute->deleteRute($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('rute');
    }
}
