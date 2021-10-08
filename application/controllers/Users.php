<?php

use Spipu\Html2Pdf\Html2Pdf;

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // meload file ref_users_model.php
        $this->load->model('Ref_users_model', 'users');
    }

    public function index()
    {
        // menangkap data pencarian users
        $nama = $this->input->post('nama');


        // settingan halaman
        $config['base_url'] = base_url('users/index');
        $config['total_rows'] = $this->users->countUsers();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['nama'] = $nama;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian users
        if ($nama) {
            $data['page'] = 0;
            $offset = 0;
            $data['users'] = $this->users->findUsers($nama, $limit, $offset);
        } else {
            $data['users'] = $this->users->getUsers($limit, $offset);
        }

        // meload view pada users/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('users/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada form
    private $rules = [
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
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'is_active',
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
                'nip' => htmlspecialchars($this->input->post('nip', true)),
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => htmlspecialchars($this->input->post('password', true)),
                'is_active' => htmlspecialchars($this->input->post('is_active', true)),
                'date_created' => time()
            ];
            // simpan data ke database melalui model
            $this->users->createUsers($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('users');
        }

        // meload view pada bus_truk/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('users/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data bus dan truk yang akan diubah
        $data['users'] = $this->users->getDetailUsers($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'nip' => htmlspecialchars($this->input->post('nip', true)),
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => htmlspecialchars($this->input->post('password', true)),
                'is_active' => htmlspecialchars($this->input->post('is_active', true)),
                'date_created' => time()
            ];
            // update data di database melalui model
            $this->users->updateUsers($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('users');
        }

        // meload view pada users/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('users/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->users->deleteUsers($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('users');
    }
}
