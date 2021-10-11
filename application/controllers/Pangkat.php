<?php

use Spipu\Html2Pdf\Html2Pdf;

class Pangkat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        // meload file ref_pangkat_model.php
        $this->load->model('Ref_pangkat_model', 'pangkat');
    }

    public function index()
    {
        // menangkap data pencarian nama pangkat
        $kdgol = $this->input->post('kdgol');

        // settingan halaman
        $config['base_url'] = base_url('pangkat/index');
        $config['total_rows'] = $this->pangkat->countPangkat();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['kdgol'] = $kdgol;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian kode golongan
        if ($kdgol) {
            $data['page'] = 0;
            $offset = 0;
            $data['pangkat'] = $this->pangkat->findPangkat($kdgol, $limit, $offset);
        } else {
            $data['pangkat'] = $this->pangkat->getPangkat($limit, $offset);
        }

        // meload view pada pangkat/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pangkat/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada form
    private $rules = [
        [
            'field' => 'kdgol',
            'label' => 'Kdgol',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'nmgol',
            'label' => 'Nmgol',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'kdgapok',
            'label' => 'Kdgapok',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'nama',
            'label' => 'nama',
            'rules' => 'required|trim'
        ],
    ];

    public function create()
    {
        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'kdgol' => htmlspecialchars($this->input->post('kdgol', true)),
                'nmgol' => htmlspecialchars($this->input->post('nmgol', true)),
                'kdgapok' => htmlspecialchars($this->input->post('kdgapok', true)),
                'nama' => htmlspecialchars($this->input->post('nama', true))
            ];
            // simpan data ke database melalui model
            $this->pangkat->createPangkat($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('pangkat');
        }

        // meload view pada pangkat/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pangkat/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data dokumen yang akan diubah
        $data['pangkat'] = $this->pangkat->getDetailPangkat($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'kdgol' => htmlspecialchars($this->input->post('kdgol', true)),
                'nmgol' => htmlspecialchars($this->input->post('nmgol', true)),
                'kdgapok' => htmlspecialchars($this->input->post('kdgapok', true)),
                'nama' => htmlspecialchars($this->input->post('nama', true))
            ];
            // update data di database melalui model
            $this->pangkat->updatePangkat($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('pangkat');
        }

        // meload view pada pangkat/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pangkat/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->pangkat->deletePangkat($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('pangkat');
    }
}
