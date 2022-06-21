<?php

class Pegawai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        // meload file ref_sub_rute_model.php
        $this->load->model('Data_pegawai_model', 'pegawai');
        $this->load->model('Ref_kubik_model', 'kubik');
        $this->load->model('Ref_rute_model', 'rute');
        $this->load->model('Data_timeline_model', 'timeline');
        $this->load->model('View_pegawai_sk_model', 'pegawai_sk');
        $this->load->model('Data_hris_model', 'hris');
        $this->load->model('Ref_pangkat_model', 'pangkat');
    }

    public function index($sk_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($sk_id)) show_404();

        // mengirim data id sk ke view
        $data['sk_id'] = $sk_id;

        // menangkap data pencarian nmpeg
        $nmpeg = $this->input->post('nmpeg');

        // settingan halaman
        $config['base_url'] = base_url('pegawai/index/' . $sk_id . '/a');
        $config['total_rows'] = $this->pegawai->countPegawaiMutasi($sk_id);
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(5) ? $this->uri->segment(5) : 0;
        $data['nmpeg'] = $nmpeg;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian nmpeg 
        if ($nmpeg) {
            $data['page'] = 0;
            $offset = 0;
            $data['pegawai'] = $this->pegawai->findPegawai($sk_id, $nmpeg, $limit, $offset);
        } else {
            $data['pegawai'] = $this->pegawai->getPegawai($sk_id, $limit, $offset);
        }

        // meload view pada pegawai/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pegawai/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada seluruh form
    private $rules = [
        [
            'field' => 'nip',
            'label' => 'NIP',
            'rules' => 'required|trim|exact_length[18]'
        ],
        [
            'field' => 'nmpeg',
            'label' => 'Nama Pegawai',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'kdgapok',
            'label' => 'Kdgapok',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'kdkawin',
            'label' => 'Kdkawin',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'rekening',
            'label' => 'Rekening',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'nm_bank',
            'label' => 'Nama Bank',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'nmrek',
            'label' => 'Nama Rekening',
            'rules' => 'required|trim'
        ]
    ];

    public function create($sk_id = null)
    {
        // cek apakah ada rute id apa tidak
        if (!isset($sk_id)) show_404();

        // tampilkan id rute
        $data['sk_id'] = $sk_id;

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'sk_id' => $sk_id,
                'nip' => htmlspecialchars($this->input->post('nip', true)),
                'nmpeg' => htmlspecialchars($this->input->post('nmpeg', true)),
                'kdgapok' => htmlspecialchars($this->input->post('kdgapok', true)),
                'kdkawin' => htmlspecialchars($this->input->post('kdkawin', true)),
                'rekening' => htmlspecialchars($this->input->post('rekening', true)),
                'nm_bank' => htmlspecialchars($this->input->post('nm_bank', true)),
                'nmrek' => htmlspecialchars($this->input->post('nmrek', true))
            ];
            // simpan data ke database melalui model
            $this->pegawai->createPegawai($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('pegawai/index/' . $sk_id . '/a');
        }

        // meload view pada pegawai/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pegawai/create', $data);
        $this->load->view('template/footer');
    }

    public function update($id = null, $sk_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();
        if (!isset($sk_id)) show_404();

        // load data sk id ke view
        $data['sk_id'] = $sk_id;
        // load data pegawai ke view berdasarkan id pegawai
        $data['pegawai'] = $this->pegawai->getDetailPegawai($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'sk_id' => $sk_id,
                'nip' => htmlspecialchars($this->input->post('nip', true)),
                'nmpeg' => htmlspecialchars($this->input->post('nmpeg', true)),
                'kdgapok' => htmlspecialchars($this->input->post('kdgapok', true)),
                'kdkawin' => htmlspecialchars($this->input->post('kdkawin', true)),
                'rekening' => htmlspecialchars($this->input->post('rekening', true)),
                'nm_bank' => htmlspecialchars($this->input->post('nm_bank', true)),
                'nmrek' => htmlspecialchars($this->input->post('nmrek', true)),
                'infant' => htmlspecialchars($this->input->post('infant', true)),
                'art' => htmlspecialchars($this->input->post('art', true)),
                'tgl_spd' => strtotime(htmlspecialchars($this->input->post('tgl_spd', true))),
                'no_spd' => htmlspecialchars($this->input->post('no_spd', true)),
                'jabatan' => htmlspecialchars($this->input->post('jabatan', true)),
                'tingkat' => htmlspecialchars($this->input->post('tingkat', true))
            ];
            // update data di database melalui model
            $this->pegawai->updatePegawai($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('pegawai/index/' . $sk_id . '/a');
        }

        // meload view pada rute/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pegawai/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null, $sk_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();
        if (!isset($sk_id)) show_404();

        // hapus data di database melalui model
        if ($this->pegawai->deletePegawai($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('pegawai/index/' . $sk_id . '/a');
    }

    public function tarik_pegawai_gaji($sk_id = null)
    {
        // cek apakah ada rute id apa tidak
        if (!isset($sk_id)) show_404();

        // mengirim data id sk ke view
        $data['sk_id'] = $sk_id;

        // menangkap data pencarian nmpeg
        $nmpeg = $this->input->post('nmpeg');

        // settingan halaman
        $config['base_url'] = base_url('pegawai/tarik-pegawai-gaji/' . $sk_id . '/a');
        $config['total_rows'] = $this->pegawai->countPegawaiGaji();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(5) ? $this->uri->segment(5) : 0;
        $data['nmpeg'] = $nmpeg;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian nmpeg
        if ($nmpeg) {
            $data['page'] = 0;
            $offset = 0;
            $data['pegawai'] = $this->pegawai->findPegawaiGaji($nmpeg, $limit, $offset);
        } else {
            $id = null;
            $data['pegawai'] = $this->pegawai->getPegawaiGaji($id, $limit, $offset);
        }

        // meload view pada pegawai/tarik_pegawai_gaji.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pegawai/tarik_pegawai_gaji', $data);
        $this->load->view('template/footer');
    }

    public function pilih_pegawai_gaji($nip = null, $sk_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($nip)) show_404();
        if (!isset($sk_id)) show_404();

        //load data berdasarkan nip dari data pegawai gaji
        $pegawai = $this->pegawai->findPegawaiGaji($nip, null, 0);

        foreach ($pegawai as $r) {
            $data = [
                'sk_id' => $sk_id,
                'nip' => $r['nip'],
                'nmpeg' => $r['nmpeg'],
                'kdgapok' => $r['kdgapok'],
                'kdkawin' => $r['kdkawin'],
                'rekening' => $r['rekening'],
                'nm_bank' => $r['nm_bank'],
                'nmrek' => $r['nmrek']
            ];
            // simpan data di database melalui model
            $this->pegawai->createPegawai($data);
        }
        // update timeline
        $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
        redirect('pegawai/index/' . $sk_id . '/a');
    }

    public function ubah_kubik($id = null, $sk_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();
        if (!isset($sk_id)) show_404();

        // load data sk id ke view
        $data['sk_id'] = $sk_id;
        // load data pegawai ke view berdasarkan id pegawai
        $data['pegawai'] = $this->pegawai->getDetailPegawai($id);
        $gol = substr($data['pegawai']['kdgapok'], 0, 1);
        $kdkawin = $data['pegawai']['kdkawin'];
        $data['kubik'] = $this->kubik->findJumlahKubik($gol, $kdkawin)['jumlah'];

        $rules = [
            [
                'field' => 'kubik',
                'label' => 'Jumlah Kubik',
                'rules' => 'required|trim|numeric'
            ],
        ];
        $validation = $this->form_validation->set_rules($rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'kubik' => htmlspecialchars($this->input->post('kubik', true))
            ];
            // update data di database melalui model
            $this->pegawai->updatePegawai($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('pegawai/index/' . $sk_id . '/a');
        }

        // meload view pada rute/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pegawai/kubik', $data);
        $this->load->view('template/footer');
    }

    public function cari_rute($id = null, $sk_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();
        if (!isset($sk_id)) show_404();

        // load data sk id ke view
        $data['pegawai_id'] = $id;
        $data['sk_id'] = $sk_id;

        // menangkap data pencarian asal dan tujuan rute
        $asal = $this->input->post('asal');
        $tujuan = $this->input->post('tujuan');

        // settingan halaman
        $config['base_url'] = base_url('pegawai/cari-rute/' . $id . '/' . $sk_id . '/a');
        $config['total_rows'] = $this->rute->countRute();
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(6) ? $this->uri->segment(6) : 0;
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
        $this->load->view('pegawai/cari_rute', $data);
        $this->load->view('template/footer');
    }

    public function pilih_rute($ref_rute_id = null, $pegawai_id = null, $sk_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($ref_rute_id)) show_404();
        if (!isset($pegawai_id)) show_404();
        if (!isset($sk_id)) show_404();

        $data = [
            'ref_rute_id' => $ref_rute_id
        ];

        // ubah data melalui model
        if ($this->pegawai->updatePegawai($data, $pegawai_id)) {
            // rekam data_timeline
            // cek apakah sudah ada data apa belum
            $proses_id = '1';
            $data_timeline = [
                'pegawai_id' => $pegawai_id,
                'proses_id' => $proses_id,
                'keterangan' => 'Nomor ' . $this->pegawai_sk->getDetailPegawaiSk($pegawai_id)['nomor'] . ', tentang ' . $this->pegawai_sk->getDetailPegawaiSk($pegawai_id)['uraian'],
                'tanggal' => $this->pegawai_sk->getDetailPegawaiSk($pegawai_id)['tanggal']
            ];
            if ($this->timeline->cekTimeline($pegawai_id, $proses_id)) {
                $this->timeline->updateTimeline($data_timeline, $pegawai_id, $proses_id);
            } else {
                $this->timeline->createTimeline($data_timeline);
            }
            // selesai
            $this->session->set_flashdata('pesan', 'Data rute berhasil diubah.');
        }
        redirect('pegawai/index/' . $sk_id . '/a');
    }

    public function tarik_pegawai_hris($sk_id = null)
    {
        // cek apakah ada rute id apa tidak
        if (!isset($sk_id)) show_404();

        // mengirim data id sk ke view
        $data['sk_id'] = $sk_id;

        // menangkap data pencarian nip
        $nip = $this->input->post('nip');
        if ($nip) {
            $data['pegawai'] = $this->hris->getProfil($nip)['Data'];
        } else {
            $data['pegawai'] = [
                'Nip18' => '',
                'Nama' => '',
                'KodeGolonganRuang' => ''
            ];
        }
        // meload view pada pegawai/tarik_pegawai_hris.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('pegawai/tarik_pegawai_hris', $data);
        $this->load->view('template/footer');
    }

    public function pilih_pegawai_hris($nip = null, $sk_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($nip)) show_404();
        if (!isset($sk_id)) show_404();

        //load data berdasarkan nip dari data pegawai gaji
        $pegawai = $this->hris->getProfil($nip)['Data'];
        $kdgapok = $this->pangkat->getKdgapok($pegawai['KodeGolonganRuang'])['kdgapok'];
            $data = [
                'sk_id' => $sk_id,
                'nip' => $pegawai['Nip18'],
                'nmpeg' => $pegawai['Nama'],
                'kdgapok' => $kdgapok,
                'kdkawin' => '',
                'rekening' => '',
                'nm_bank' => '',
                'nmrek' => ''
            ];
            // simpan data di database melalui model
            $this->pegawai->createPegawai($data);
        // update timeline
        $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
        redirect('pegawai/index/' . $sk_id . '/a');
    }
}
