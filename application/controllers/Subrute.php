<?php

class Subrute extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        // meload file ref_sub_rute_model.php
        $this->load->model('Ref_sub_rute_model', 'subrute');
        $this->load->model('Ref_jenis_model', 'jenis_rute');
        $this->load->model('Ref_angkutan_model', 'jenis_angkutan');
        $this->load->model('Ref_pesawat_model', 'pesawat');
        $this->load->model('Ref_kapal_model', 'kapal');
        $this->load->model('Ref_darat_model', 'darat');
        $this->load->model('Ref_packing_model', 'packing');
    }

    public function index($rute_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($rute_id)) show_404();

        // load data sub rute
        $data['subrute'] = $this->subrute->getSubRute($rute_id);
        $data['rute_id'] = $rute_id;

        // meload view pada subrute/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('subrute/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada seluruh form
    private $rules = [
        [
            'field' => 'jenis_id',
            'label' => 'Jenis Id',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'angkutan_id',
            'label' => 'Angkutan Id',
            'rules' => 'required|trim'
        ]
    ];

    public function create($rute_id = null)
    {
        // cek apakah ada rute id apa tidak
        if (!isset($rute_id)) show_404();

        // tampilkan jenis rute dan jenis angkutan
        $data['jenis_rute'] = $this->jenis_rute->getAllJenis();
        $data['jenis_angkutan'] = $this->jenis_angkutan->getAllAngkutan();
        $data['rute_id'] = $rute_id;

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'rute_id' => $rute_id,
                'jenis_id' => htmlspecialchars($this->input->post('jenis_id', true)),
                'angkutan_id' => htmlspecialchars($this->input->post('angkutan_id', true))
            ];
            // simpan data ke database melalui model
            $this->subrute->createSubRute($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('subrute/index/' . $rute_id . '');
        }

        // meload view pada rute/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('subrute/create', $data);
        $this->load->view('template/footer');
    }

    public function update($id = null, $rute_id = null, $angkutan_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();
        if (!isset($rute_id)) show_404();
        if (!isset($angkutan_id)) show_404();

        // load data ref angkutan berdasarkan angkutan id
        if ($angkutan_id == 1) {
            $ref['angkutan'] = $this->pesawat->getAllPesawat();
        } else if ($angkutan_id == 4) {
            $ref['angkutan'] = $this->kapal->getAllKapal();
        } else if ($angkutan_id == 5) {
            $ref['angkutan'] = $this->packing->getAllPacking();
        } else {
            $ref['angkutan'] = $this->darat->getAllDarat();
        }

        // load data rute id ke view
        $ref['rute_id'] = $rute_id;
        // load data sub rute ke view berdasarkan id sub rute
        $ref['subrute'] = $this->subrute->getDetailSubRute($id);

        $curRules = [
            [
                'field' => 'ref_id',
                'label' => 'Ref Id',
                'rules' => 'required|trim'
            ]
        ];

        $validation = $this->form_validation->set_rules($curRules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'ref_id' => htmlspecialchars($this->input->post('ref_id', true))
            ];
            // update data di database melalui model
            $this->subrute->updateSubRute($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('subrute/index/' . $rute_id . '');
        }

        // meload view pada rute/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('subrute/update', $ref);
        $this->load->view('template/footer');
    }

    public function delete($id = null, $rute_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();
        if (!isset($rute_id)) show_404();

        // hapus data di database melalui model
        if ($this->subrute->deleteSubRute($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('subrute/index/' . $rute_id . '');
    }
}
