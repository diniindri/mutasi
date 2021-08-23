<?php

use Spipu\Html2Pdf\Html2Pdf;

class Payroll extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Data_sk_model', 'sk');
        $this->load->model('Data_payroll_model', 'payroll');
    }

    public function index()
    {
        // menangkap data pencarian uraian Payroll
        $uraian = $this->input->post('uraian');

        // settingan halaman
        $config['base_url'] = base_url('payroll/index');
        $config['total_rows'] = 10;
        $config['per_page'] = 5;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['uraian'] = $uraian;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian uraian sk
        if ($uraian) {
            $data['page'] = 0;
            $offset = 0;
            $data['sk'] = $this->sk->findSk($uraian, $limit, $offset);
        } else {
            $data['sk'] = $this->sk->getSk($limit, $offset);
        }


        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('payroll/index', $data);
        $this->load->view('template/footer');
    }

    public function detail($sk_id = null)
    {
        // cek apakah ada sk id apa tidak
        if (!isset($sk_id)) show_404();

        // mengirim data id sk ke view
        $data['sk_id'] = $sk_id;

        // menangkap data pencarian uraian payroll
        $uraian = $this->input->post('uraian');

        // settingan halaman
        $config['base_url'] = base_url('payroll/detail/' . $sk_id . '');
        $config['total_rows'] = $this->payroll->countPayroll();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
        $data['uraian'] = $uraian;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian uraian 
        if ($uraian) {
            $data['page'] = 0;
            $offset = 0;
            $data['payroll'] = $this->payroll->findPayroll($sk_id, $uraian, $limit, $offset);
        } else {
            $data['payroll'] = $this->payroll->getPayroll($sk_id, $limit, $offset);
        }

        // meload view pada pegawai/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('payroll/detail', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada form
    private $rules = [
        [
            'field' => 'uraian',
            'label' => 'Uraian',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'tanggal',
            'label' => 'Tanggal',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'jumlah',
            'label' => 'Jumlah',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'nominal',
            'label' => 'Nominal',
            'rules' => 'required|trim'
        ]
    ];

    public function create($sk_id = null)
    {
        $validation = $this->form_validation->set_rules($this->rules);

        // mengirim data id sk ke view
        $data['sk_id'] = $sk_id;

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'uraian' => htmlspecialchars($this->input->post('uraian', true)),
                'tanggal' => strtotime(htmlspecialchars($this->input->post('tanggal', true))),
                'jumlah' => htmlspecialchars($this->input->post('jumlah', true)),
                'nominal' => htmlspecialchars($this->input->post('nominal', true)),
                'sk_id' => $sk_id
            ];

            // simpan data ke database melalui model
            $this->payroll->createPayroll($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('payroll/detail/' . $sk_id . '');
        }

        // meload view pada kapal/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('payroll/create', $data);
        $this->load->view('template/footer');
    }

    public function update($sk_id = null, $id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // mengirim data id sk ke view
        $data['sk_id'] = $sk_id;

        // load data packing yang akan diubah
        $data['payroll'] = $this->payroll->getDetailPayroll($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'uraian' => htmlspecialchars($this->input->post('uraian', true)),
                'tanggal' => strtotime(htmlspecialchars($this->input->post('tanggal', true))),
                'jumlah' => htmlspecialchars($this->input->post('jumlah', true)),
                'nominal' => htmlspecialchars($this->input->post('nominal', true))
            ];
            // update data di database melalui model
            $this->payroll->updatePayroll($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('payroll/detail/' . $sk_id . '');
        }

        // meload view pada kapal/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('payroll/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($sk_id = null, $id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->payroll->deletePayroll($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('payroll/detail/' . $sk_id . '');
    }
}
