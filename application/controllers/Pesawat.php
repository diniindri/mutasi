<?php

use Spipu\Html2Pdf\Html2Pdf;

class Pesawat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        // meload file ref_pesawat_model.php
        $this->load->model('Ref_pesawat_model', 'pesawat');
    }

    public function index()
    {
        // menangkap data pencarian asal dan tujuan pesawat
        $asal = $this->input->post('asal');
        $tujuan = $this->input->post('tujuan');

        // settingan halaman
        $config['base_url'] = base_url('pesawat/index');
        $config['total_rows'] = $this->pesawat->countPesawat();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['asal'] = $asal;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian asal dan tujuan pesawat
        if ($asal) {
            $data['page'] = 0;
            $offset = 0;
            $data['pesawat'] = $this->pesawat->findPesawat($asal, $tujuan, $limit, $offset);
        } else {
            $data['pesawat'] = $this->pesawat->getPesawat($limit, $offset);
        }

        // meload view pada pesawat/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pesawat/index', $data);
        $this->load->view('template/footer');
    }

    public function create()
    {
        // validasi inputan pada form
        $rules = [
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
                'label' => 'Nominal',
                'rules' => 'required|trim|numeric'
            ]
        ];
        $validation = $this->form_validation->set_rules($rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'kota_asal' => htmlspecialchars($this->input->post('kota_asal', true)),
                'kota_tujuan' => htmlspecialchars($this->input->post('kota_tujuan', true)),
                'jumlah' => htmlspecialchars($this->input->post('jumlah', true))
            ];
            // simpan data ke database melalui model
            $this->pesawat->createPesawat($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('pesawat');
        }

        // meload view pada pesawat/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pesawat/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data pesawat yang akan diubah
        $data['pesawat'] = $this->pesawat->getDetailPesawat($id);

        // validasi inputan pada form
        $rules = [
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
                'label' => 'Nominal',
                'rules' => 'required|trim|numeric'
            ]
        ];
        $validation = $this->form_validation->set_rules($rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'kota_asal' => htmlspecialchars($this->input->post('kota_asal', true)),
                'kota_tujuan' => htmlspecialchars($this->input->post('kota_tujuan', true)),
                'jumlah' => htmlspecialchars($this->input->post('jumlah', true))
            ];
            // update data di database melalui model
            $this->pesawat->updatePesawat($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('pesawat');
        }

        // meload view pada pesawat/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pesawat/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->pesawat->deletePesawat($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('pesawat');
    }
}
