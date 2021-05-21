<?php

use Spipu\Html2Pdf\Html2Pdf;

class Kapal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // meload file ref_kapal_model.php
        $this->load->model('Ref_kapal_model', 'kapal');
    }

    public function index()
    {
        // menangkap data pencarian asal dan tujuan kapal
        $asal = $this->input->post('asal');
        $tujuan = $this->input->post('tujuan');

        // settingan halaman
        $config['base_url'] = base_url('kapal/index');
        $config['total_rows'] = $this->kapal->countKapal();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['asal'] = $asal;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian asal dan tujuan kapal
        if ($asal) {
            $data['page'] = 0;
            $offset = 0;
            $data['kapal'] = $this->kapal->findKapal($asal, $tujuan, $limit, $offset);
        } else {
            $data['kapal'] = $this->kapal->getKapal($limit, $offset);
        }

        // meload view pada kapal/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('kapal/index', $data);
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
            $this->kapal->createKapal($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('kapal');
        }

        // meload view pada kapal/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('kapal/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data kapal yang akan diubah
        $data['kapal'] = $this->kapal->getDetailKapal($id);

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
            $this->kapal->updateKapal($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('kapal');
        }

        // meload view pada kapal/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('kapal/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->kapal->deleteKapal($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('kapal');
    }
}
