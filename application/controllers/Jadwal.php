<?php

use Spipu\Html2Pdf\Html2Pdf;

class Jadwal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        $this->load->model('Data_sk_model', 'sk');
        $this->load->model('Data_jadwal_model', 'jadwal');
    }


    public function detail($sk_id = null)
    {
        // cek apakah ada sk id apa tidak
        if (!isset($sk_id)) show_404();

        // mengirim data id sk ke view
        $data['sk_id'] = $sk_id;

        // menangkap data pencarian uraian
        $uraian = $this->input->post('uraian');

        // settingan halaman
        $config['base_url'] = base_url('jadwal/detail/' . $sk_id . '/a');
        $config['total_rows'] = $this->jadwal->countJadwal($sk_id);
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(5) ? $this->uri->segment(5) : 0;
        $data['uraian'] = $uraian;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian uraian 
        if ($uraian) {
            $data['page'] = 0;
            $offset = 0;
            $data['jadwal'] = $this->jadwal->findJadwal($sk_id, $uraian, $limit, $offset);
        } else {
            $data['jadwal'] = $this->jadwal->getJadwal($sk_id, $limit, $offset);
        }

        // meload view pada pegawai/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('jadwal/detail', $data);
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
            'field' => 'pic',
            'label' => 'PIC',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'tglawal',
            'label' => 'Tanggal Awal',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'tglakhir',
            'label' => 'Tanggal Akhir',
            'rules' => 'required|trim'
        ]
    ];
    public function create($sk_id = null)
    {
        // cek apakah ada sk id apa tidak
        if (!isset($sk_id)) show_404();

        // mengirim data id sk ke view
        $data['sk_id'] = $sk_id;

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'uraian' => htmlspecialchars($this->input->post('uraian', true)),
                'pic' => htmlspecialchars($this->input->post('pic', true)),
                'tglawal' => strtotime(htmlspecialchars($this->input->post('tglawal', true))),
                'tglakhir' => strtotime(htmlspecialchars($this->input->post('tglakhir', true))),
                'sk_id' => $sk_id
            ];
            // simpan data ke database melalui model
            $this->jadwal->createJadwal($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('jadwal/detail/' . $sk_id . '/a');
        }

        // meload view pada dokumen/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('jadwal/create', $data);
        $this->load->view('template/footer');
    }

    public function update($sk_id = null, $id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // mengirim data id sk ke view
        $data['sk_id'] = $sk_id;

        // load data dokumen yang akan diubah
        $data['jadwal'] = $this->jadwal->getDetailJadwal($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'uraian' => htmlspecialchars($this->input->post('uraian', true)),
                'pic' => htmlspecialchars($this->input->post('pic', true)),
                'tglawal' => strtotime(htmlspecialchars($this->input->post('tglawal', true))),
                'tglakhir' => strtotime(htmlspecialchars($this->input->post('tglakhir', true))),
                'sk_id' => $sk_id
            ];
            // update data di database melalui model
            $this->jadwal->updateJadwal($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('jadwal/detail/' . $sk_id . '/a');
        }

        // meload view pada jadwal/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('jadwal/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($sk_id = null, $id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->jadwal->deleteJadwal($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('jadwal/detail/' . $sk_id . '/a');
    }
}
