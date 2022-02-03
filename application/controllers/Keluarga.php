<?php

class Keluarga extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        // meload file Data_keluarga_model.php
        $this->load->model('Data_keluarga_model', 'keluarga');
        $this->load->model('Data_pegawai_model', 'pegawai');
        $this->load->model('Ref_status_keluarga_model', 'status_keluarga');
        $this->load->model('Data_timeline_model', 'timeline');
    }

    public function index($pegawai_id = null, $sk_id)
    {
        // cek apakah ada id apa tidak
        if (!isset($pegawai_id)) show_404();
        if (!isset($sk_id)) show_404();

        // mengirim pegawai_id ke view
        $data['pegawai_id'] = $pegawai_id;
        $data['sk_id'] = $sk_id;
        // mencari nip ybs dan mengirim ke view
        $data['nip'] = $this->pegawai->getDetailPegawai($pegawai_id)['nip'];

        // menangkap data pencarian nama keluarga
        $nama = $this->input->post('nama');

        // settingan halaman
        $config['base_url'] = base_url('keluarga/index/' . $pegawai_id . '/' . $sk_id . '/a');
        $config['total_rows'] = $this->keluarga->countKeluargaPegawai($pegawai_id);
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(6) ? $this->uri->segment(6) : 0;
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

    public function create($pegawai_id = null, $sk_id)
    {
        // cek apakah ada rute id apa tidak
        if (!isset($pegawai_id)) show_404();
        if (!isset($sk_id)) show_404();

        // tampilkan id rute
        $data['pegawai_id'] = $pegawai_id;
        $data['sk_id'] = $sk_id;
        $data['status_keluarga'] = $this->status_keluarga->getStatusKeluarga(null, 0);

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
            if ($this->keluarga->createKeluarga($data)) {
                // update data pegawai, ubah data infant dan data art pada data keluarga
                $infant = $this->keluarga->hitungInfant($pegawai_id);
                $art = $this->keluarga->hitungArt($pegawai_id);
                $this->pegawai->updatePegawai(['infant' => $infant, 'art' => $art], $pegawai_id);
            }
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('keluarga/index/' . $pegawai_id . '/' . $sk_id . '/a');
        }

        // meload view pada keluarga/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('keluarga/create', $data);
        $this->load->view('template/footer');
    }

    public function update($id = null, $pegawai_id = null, $sk_id)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();
        if (!isset($pegawai_id)) show_404();
        if (!isset($sk_id)) show_404();

        // load data sk id ke view
        $data['pegawai_id'] = $pegawai_id;
        $data['sk_id'] = $sk_id;
        // load data keluarga ke view berdasarkan id keluarga
        $data['keluarga'] = $this->keluarga->getDetailKeluarga($id);
        $data['status_keluarga'] = $this->status_keluarga->getStatusKeluarga(null, 0);

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
            if ($this->keluarga->updateKeluarga($data, $id)) {
                // update data pegawai, ubah data infant dan data art pada data keluarga
                $infant = $this->keluarga->hitungInfant($pegawai_id);
                $art = $this->keluarga->hitungArt($pegawai_id);
                $this->pegawai->updatePegawai(['infant' => $infant, 'art' => $art], $pegawai_id);
            }
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('keluarga/index/' . $pegawai_id . '/' . $sk_id . '/a');
        }

        // meload view pada keluarga/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('keluarga/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null, $pegawai_id = null, $sk_id)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();
        if (!isset($pegawai_id)) show_404();
        if (!isset($sk_id)) show_404();

        // hapus data di database melalui model
        if ($this->keluarga->deleteKeluarga($id)) {
            // update data pegawai, ubah data infant dan data art pada data keluarga
            $infant = $this->keluarga->hitungInfant($pegawai_id);
            $art = $this->keluarga->hitungArt($pegawai_id);
            $this->pegawai->updatePegawai(['infant' => $infant, 'art' => $art], $pegawai_id);
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('keluarga/index/' . $pegawai_id . '/' . $sk_id . '/a');
    }

    public function tarik_keluarga_gaji($nip = null, $pegawai_id = null, $sk_id)
    {
        // cek apakah ada id apa tidak
        if (!isset($nip)) show_404();
        if (!isset($pegawai_id)) show_404();
        if (!isset($sk_id)) show_404();

        // cari data keluarga berdasarkan nip
        $keluarga = $this->keluarga->findKeluargaGaji($nip, null, 0);
        foreach ($keluarga as $r) {
            $data = [
                'pegawai_id' => $pegawai_id,
                'nama' => $r['nama'],
                'kdkeluarga' => $r['kdkeluarga'],
                'tgllhr' => $r['tgllhr'],
                'kddapat' => $r['kddapat'],
                'sts' => 0
            ];
            // simpan data ke database melalui model
            $this->keluarga->createKeluarga($data);
        }
        // rekam data_timeline
        // cek apakah sudah ada data apa belum
        $proses_id = '3';
        $data_timeline = [
            'pegawai_id' => $pegawai_id,
            'proses_id' => $proses_id,
            'keterangan' => 'Kantor Pusat telah melakukan proses verifikasi data keluarga',
            'tanggal' => time()
        ];
        if ($this->timeline->cekTimeline($pegawai_id, $proses_id)) {
            $this->timeline->updateTimeline($data_timeline, $pegawai_id, $proses_id);
        } else {
            $this->timeline->createTimeline($data_timeline);
        }
        // selesai
        $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
        redirect('keluarga/index/' . $pegawai_id . '/' . $sk_id . '/a');
    }
}
