<?php

class sk_mutasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        // meload file Data_sk_model.php
        $this->load->model('Data_sk_model', 'sk');
    }

    public function index()
    {
        // menangkap data pencarian uraian sk
        $uraian = $this->input->post('uraian');

        // settingan halaman
        $config['base_url'] = base_url('sk-mutasi/index');
        $config['total_rows'] = $this->sk->countSk();
        $config['per_page'] = 10;
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

        // meload view pada sk/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('sk_mutasi/index', $data);
        $this->load->view('template/footer');
    }

    // validasi inputan pada form
    private $rules = [
        [
            'field' => 'nomor',
            'label' => 'Nomor',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'tanggal',
            'label' => 'Tanggal',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'uraian',
            'label' => 'Uraian',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'nospp',
            'label' => 'Nomor SPP',
            'rules' => 'required|trim|exact_length[5]'
        ],
        [
            'field' => 'tglspp',
            'label' => 'Tanggal SPP',
            'rules' => 'required|trim'
        ]
    ];

    public function create()
    {
        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'nomor' => htmlspecialchars($this->input->post('nomor', true)),
                'tanggal' => strtotime(htmlspecialchars($this->input->post('tanggal', true))),
                'uraian' => htmlspecialchars($this->input->post('uraian', true)),
                'status' => htmlspecialchars($this->input->post('status', true)),
                'nospp' => htmlspecialchars($this->input->post('nospp', true)),
                'tglspp' => strtotime(htmlspecialchars($this->input->post('tglspp', true))),
            ];
            // simpan data ke database melalui model
            $this->sk->createSk($data);
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
            redirect('sk-mutasi');
        }

        // meload view pada sk/create.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('sk_mutasi/create');
        $this->load->view('template/footer');
    }

    public function update($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // load data packing yang akan diubah
        $data['sk'] = $this->sk->getDetailSk($id);

        $validation = $this->form_validation->set_rules($this->rules);

        // jika validasi sukses
        if ($validation->run()) {
            $data = [
                'nomor' => htmlspecialchars($this->input->post('nomor', true)),
                'tanggal' => strtotime(htmlspecialchars($this->input->post('tanggal', true))),
                'uraian' => htmlspecialchars($this->input->post('uraian', true)),
                'status' => htmlspecialchars($this->input->post('status', true)),
                'nospp' => htmlspecialchars($this->input->post('nospp', true)),
                'tglspp' => strtotime(htmlspecialchars($this->input->post('tglspp', true)))
            ];
            // update data di database melalui model
            $this->sk->updateSk($data, $id);
            $this->session->set_flashdata('pesan', 'Data berhasil diubah.');
            redirect('sk-mutasi');
        }

        // meload view pada sk/update.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('sk_mutasi/update', $data);
        $this->load->view('template/footer');
    }

    public function delete($id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();

        // hapus data di database melalui model
        if ($this->sk->deleteSk($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('sk-mutasi');
    }

    public function nd($sk_id = null)
    {
        if (!isset($sk_id)) show_404();

        $data['sk_id'] = $sk_id;

        $validation = $this->form_validation->set_rules('file', 'File', 'trim');
        if ($validation->run() && $_FILES) {
            //upload file pdf
            $upload_file = $_FILES['file']['name'];
            if ($upload_file) {
                $config['allowed_types'] = 'pdf';
                $config['remove_spaces'] = TRUE;
                $config['max_size']     = '10000';
                $config['encrypt_name']     = TRUE;
                $config['upload_path'] = 'assets/files/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $new_file = $this->upload->data('file_name');
                    $this->db->set('file', $new_file);
                    $data = [
                        'file' => $new_file
                    ];
                    $this->sk->updateSk($data, $sk_id);
                    redirect('sk-mutasi');
                } else {
                    echo $this->upload->display_errors();
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Upload file gagal, mohon menggunakan format file pdf dan ukuran maksimal 10 MB!</div>');
                    redirect('sk-mutasi');
                }
            }
        }

        // form
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('sk_mutasi/nd', $data);
        $this->load->view('template/footer');
    }
}
