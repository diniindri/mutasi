<?php

class Keluarga extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // meload file Data_keluarga_model.php
        $this->load->model('Data_keluarga_model', 'keluarga');
    }

    public function index($pegawai_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($pegawai_id)) show_404();

        // mengirim data id sk ke view
        $data['pegawai_id'] = $pegawai_id;

        // menangkap data pencarian nama keluarga
        $nama = $this->input->post('nama');

        // settingan halaman
        $config['base_url'] = base_url('keluarga/index/' . $pegawai_id . '');
        $config['total_rows'] = $this->keluarga->countKeluarga();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
        $data['nama'] = $nama;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian nama keluarga 
        if ($nama) {
            $data['page'] = 0;
            $offset = 0;
            $data['keluarga'] = $this->keluarga->findKeluarga($pegawai_id, $nama, $limit, $offset);
        } else {
            $data['keluarga'] = $this->keluarga->getKeluarga($pegawai_id, $limit, $offset);
        }

        // meload view pada keluarga/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('keluarga/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada seluruh form
    private $rules = [
        [
            'field' => 'nama',
            'label' => 'Nama',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'kdkeluarga',
            'label' => 'Status Keluarga',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'tgllhr',
            'label' => 'Tanggal Lahir',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'kddapat',
            'label' => 'Status Tunjangan',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'sts',
            'label' => 'Status Usia',
            'rules' => 'required|trim'
        ],
    ];

    public function create($pegawai_id = null)
    {
        // cek apakah ada rute id apa tidak
        if (!isset($pegawai_id)) show_404();

        // tampilkan id rute
        $data['pegawai_id'] = $pegawai_id;

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'pegawai_id' => $pegawai_id,
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'kdkeluarga' => htmlspecialchars($this->input->post('kdkeluarga', true)),
                'tgllhr' => htmlspecialchars($this->input->post('tgllhr', true)),
                'kddapat' => htmlspecialchars($this->input->post('kddapat', true)),
                'sts' => htmlspecialchars($this->input->post('sts', true)),
            ];
            // simpan data ke database melalui model
            $this->keluarga->createKeluarga($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('keluarga/index/' . $pegawai_id . '');
        }

        // meload view pada keluarga/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('keluarga/create', $data);
        $this->load->view('template/footer');
    }

    public function update($id = null, $pegawai_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();
        if (!isset($pegawai_id)) show_404();

        // load data sk id ke view
        $data['pegawai_id'] = $pegawai_id;
        // load data keluarga ke view berdasarkan id keluarga
        $data['keluarga'] = $this->keluarga->getDetailKeluarga($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'pegawai_id' => $pegawai_id,
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'kdkeluarga' => htmlspecialchars($this->input->post('kdkeluarga', true)),
                'tgllhr' => htmlspecialchars($this->input->post('tgllhr', true)),
                'kddapat' => htmlspecialchars($this->input->post('kddapat', true)),
                'sts' => htmlspecialchars($this->input->post('sts', true)),
            ];
            // update data di database melalui model
            $this->keluarga->updateKeluarga($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('keluarga/index/' . $pegawai_id . '');
        }

        // meload view pada keluarga/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('keluarga/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null, $pegawai_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();
        if (!isset($pegawai_id)) show_404();

        // hapus data di database melalui model
        if ($this->keluarga->deleteKeluarga($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('keluarga/index/' . $pegawai_id . '');
    }
}
