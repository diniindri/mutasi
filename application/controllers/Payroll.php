<?php

use Spipu\Html2Pdf\Html2Pdf;

class Payroll extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        $this->load->model('Data_sk_model', 'sk');
        $this->load->model('Data_pegawai_model', 'pegawai');
        $this->load->model('Data_payroll_model', 'payroll');
        $this->load->model('Data_sub_payroll_model', 'sub_payroll');
        $this->load->model('View_pegawai_payroll_model', 'pegawai_payroll');
        $this->load->model('Data_timeline_model', 'timeline');
        $this->load->model('Ref_pejabat_model', 'pejabat');
        $this->load->model('View_biaya_pegawai_model', 'biaya_pegawai');
    }

    public function index()
    {
        // menangkap data pencarian uraian sk
        $uraian = $this->input->post('uraian');

        // settingan halaman
        $config['base_url'] = base_url('payroll/index');
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
        $config['total_rows'] = $this->payroll->countPayroll($sk_id);
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
                'tanggal' => strtotime(htmlspecialchars($this->input->post('tanggal', true)))
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

    public function pegawai($sk_id = null, $payroll_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($payroll_id)) show_404();

        // menangkap data pencarian nmpeg
        $nmpeg = $this->input->post('nmpeg');
        $data['sk_id'] = $sk_id;
        $data['payroll_id'] = $payroll_id;

        // settingan halaman
        $config['base_url'] = base_url('payroll/pegawai/' . $sk_id . '/' . $payroll_id . '');
        $config['total_rows'] = $this->pegawai_payroll->countPegawaiPayroll($payroll_id);
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
            $data['pegawai'] = $this->pegawai_payroll->findPegawaiPayroll($payroll_id, $nmpeg, $limit, $offset);
        } else {
            $data['pegawai'] = $this->pegawai_payroll->getPegawaiPayroll($payroll_id, $limit, $offset);
        }

        // meload view pada pegawai/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('payroll/pegawai', $data);
        $this->load->view('template/footer');
    }

    public function tarik_pegawai_mutasi($sk_id = null, $payroll_id = null, $a)
    {
        // cek apakah ada sk id apa tidak
        if (!isset($sk_id)) show_404();

        // mengirim data id sk ke view
        $data['sk_id'] = $sk_id;
        $data['payroll_id'] = $payroll_id;

        // menangkap data pencarian nmpeg
        $nmpeg = $this->input->post('nmpeg');

        // settingan halaman
        $config['base_url'] = base_url('payroll/tarik-pegawai-mutasi/' . $sk_id . '/' . $payroll_id . '/a');
        $config['total_rows'] = $this->pegawai->countPegawaiPayroll($sk_id);
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(6) ? $this->uri->segment(6) : 0;
        $data['nmpeg'] = $nmpeg;
        $limit = $config["per_page"];
        $offset = $data['page'];

        // pilih tampilan data, semua atau berdasarkan pencarian nmpeg
        if ($nmpeg) {
            $data['page'] = 0;
            $offset = 0;
            $data['pegawai'] = $this->pegawai->findPegawaiPayroll($sk_id, $nmpeg, $limit, $offset);
        } else {
            $data['pegawai'] = $this->pegawai->getPegawaiPayroll($sk_id, $limit, $offset);
        }

        // meload view pada pegawai/tarik_pegawai_gaji.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('payroll/tarik_pegawai_mutasi', $data);
        $this->load->view('template/footer');
    }

    public function pilih_pegawai_mutasi($sk_id = null, $payroll_id = null, $pegawai_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($payroll_id)) show_404();
        if (!isset($pegawai_id)) show_404();

        $data = [
            'payroll_id' => $payroll_id,
            'pegawai_id' => $pegawai_id
        ];
        if ($this->sub_payroll->createSubPayroll($data)) {
            //update jumlah dan nominal pada tabel data_payroll
            //hitung jumlah total pegawai dan nominal pegawai per payroll_id
            $jumlah = $this->pegawai_payroll->countPegawaiPayroll($payroll_id);
            $nominal = $this->pegawai_payroll->sumPegawaiPayroll($payroll_id);
            $this->payroll->updatePayroll(['jumlah' => $jumlah, 'nominal' => $nominal['nominal']], $payroll_id);
            //ubah status menjadi 1 pada data_pegawai
            $this->pegawai->updatePegawai(['status' => 1], $pegawai_id);

            // urutan proses ke 8
            // rekam data_timeline
            // cek apakah sudah ada data apa belum
            $proses_id = '8';
            $data_timeline = [
                'pegawai_id' => $pegawai_id,
                'proses_id' => $proses_id,
                'keterangan' => 'Kantor Pusat telah melakukan proses verifikasi dokumen Rincian Biaya dan SPD',
                'tanggal' => time()
            ];
            if ($this->timeline->cekTimeline($pegawai_id, $proses_id)) {
                $this->timeline->updateTimeline($data_timeline, $pegawai_id, $proses_id);
            } else {
                $this->timeline->createTimeline($data_timeline);
            }
            // selesai proses ke 8
            // urutan proses ke 9
            // rekam data_timeline
            // cek apakah sudah ada data apa belum
            $proses_id = '9';
            $data_timeline = [
                'pegawai_id' => $pegawai_id,
                'proses_id' => $proses_id,
                'keterangan' => 'Kantor Pusat telah melakukan proses verifikasi rekening Pegawai dan pembuatan Data Payroll',
                'tanggal' => time()
            ];
            if ($this->timeline->cekTimeline($pegawai_id, $proses_id)) {
                $this->timeline->updateTimeline($data_timeline, $pegawai_id, $proses_id);
            } else {
                $this->timeline->createTimeline($data_timeline);
            }
            // selesai proses ke 9
            $this->session->set_flashdata('pesan', 'Data berhasil ditambah.');
        }
        redirect('payroll/pegawai/' . $sk_id . '/' . $payroll_id . '');
    }

    public function hapus_pegawai($sk_id = null, $payroll_id = null, $pegawai_id = null, $id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($sk_id)) show_404();
        if (!isset($payroll_id)) show_404();

        // hapus data di database melalui model
        if ($this->sub_payroll->deleteSubPayroll($id)) {
            //update jumlah dan nominal pada tabel data_payroll
            //hitung jumlah total pegawai dan nominal pegawai per payroll_id
            $jumlah = $this->pegawai_payroll->countPegawaiPayroll($payroll_id);
            $nominal = $this->pegawai_payroll->sumPegawaiPayroll($payroll_id);
            $this->payroll->updatePayroll(['jumlah' => $jumlah, 'nominal' => $nominal['nominal']], $payroll_id);
            //ubah status menjadi 0 pada data_pegawai
            $this->pegawai->updatePegawai(['status' => 0], $pegawai_id);
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('payroll/pegawai/' . $sk_id . '/' . $payroll_id . '');
    }

    public function proses_payroll($sk_id = null, $payroll_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($sk_id)) show_404();
        if (!isset($payroll_id)) show_404();

        // ubah status menjadi 1 pada tabel data_payroll
        if ($this->payroll->updatePayroll(['status' => 1], $payroll_id)) {
            // rekam data_timeline
            // cek apakah sudah ada data apa belum
            $pegawai_payroll = $this->pegawai_payroll->getPegawaiPayroll($payroll_id, null, 0);
            foreach ($pegawai_payroll as $r) {
                $proses_id = '10';
                $pegawai_id = $r['pegawai_id'];
                $data_timeline = [
                    'pegawai_id' => $pegawai_id,
                    'proses_id' => $proses_id,
                    'keterangan' => 'Kantor Pusat telah melakukan proses payroll biaya mutasi kepada Pegawai',
                    'tanggal' => time()
                ];
                if ($this->timeline->cekTimeline($pegawai_id, $proses_id)) {
                    $this->timeline->updateTimeline($data_timeline, $pegawai_id, $proses_id);
                } else {
                    $this->timeline->createTimeline($data_timeline);
                }
            }
            // selesai
            $this->session->set_flashdata('pesan', 'Data payroll berhasil diproses.');
        }
        redirect('payroll/detail/' . $sk_id . '');
    }

    public function batal_payroll($sk_id = null, $payroll_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($sk_id)) show_404();
        if (!isset($payroll_id)) show_404();

        // ubah status menjadi 1 pada tabel data_payroll
        if ($this->payroll->updatePayroll(['status' => 0], $payroll_id)) {
            $this->session->set_flashdata('pesan', 'Data payroll berhasil dibatalkan.');
        }
        redirect('payroll/detail/' . $sk_id . '');
    }

    public function pegawai_payroll($sk_id = null, $payroll_id = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($payroll_id)) show_404();

        // menangkap data pencarian nmpeg
        $nmpeg = $this->input->post('nmpeg');
        $data['sk_id'] = $sk_id;
        $data['payroll_id'] = $payroll_id;

        // settingan halaman
        $config['base_url'] = base_url('payroll/pegawai/' . $sk_id . '/' . $payroll_id . '');
        $config['total_rows'] = $this->pegawai_payroll->countPegawaiPayroll($payroll_id);
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
            $data['pegawai'] = $this->pegawai_payroll->findPegawaiPayroll($payroll_id, $nmpeg, $limit, $offset);
        } else {
            $data['pegawai'] = $this->pegawai_payroll->getPegawaiPayroll($payroll_id, $limit, $offset);
        }

        // meload view pada pegawai/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('payroll/pegawai_payroll', $data);
        $this->load->view('template/footer');
    }

    public function excel($sk_id = null, $payroll_id = null)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'no');
        $sheet->setCellValue('B1', 'nip');
        $sheet->setCellValue('C1', 'nama');
        $sheet->setCellValue('D1', 'asal');
        $sheet->setCellValue('E1', 'tujuan');
        $sheet->setCellValue('F1', 'nominal');
        $sheet->setCellValue('G1', 'rekening');
        $sheet->setCellValue('H1', 'nama_bank');
        $sheet->setCellValue('I1', 'atas_nama');

        $pegawai = $this->pegawai_payroll->getPegawaiPayroll($payroll_id, null, 0);

        $no = 1;
        $i = 2;
        foreach ($pegawai as $r) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, ' ' . $r['nip']);
            $sheet->setCellValue('C' . $i, $r['nmpeg']);
            $sheet->setCellValue('D' . $i, $r['asal']);
            $sheet->setCellValue('E' . $i, $r['tujuan']);
            $sheet->setCellValue('F' . $i, $r['nominal']);
            $sheet->setCellValue('G' . $i, $r['rekening']);
            $sheet->setCellValue('H' . $i, $r['nm_bank']);
            $sheet->setCellValue('I' . $i, $r['nmrek']);
            $i++;
        }

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $i = $i - 1;
        $sheet->getStyle('A1:I' . $i)->applyFromArray($styleArray);

        // simpan datanya
        $date = date('d-m-y-' . substr((string)microtime(), 1, 8));
        $date = str_replace(".", "", $date);
        $filename = "excel_" . $date . ".xlsx";
        try {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save($filename);
            $content = file_get_contents($filename);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
        header("Content-Disposition: attachment; filename=" . $filename);
        unlink($filename);
        exit($content);
    }

    public function dnp($sk_id = null, $payroll_id = null)
    {
        // cek apakah ada sk id apa tidak
        if (!isset($sk_id)) show_404();

        $data['ppk'] = $this->pejabat->getKodePejabat(1);
        $data['bendahara'] = $this->pejabat->getKodePejabat(2);
        $data['biaya_pegawai'] = $this->biaya_pegawai->getBiayaPegawaiPayroll($payroll_id);

        ob_start();
        $this->load->view('payroll/dnp', $data);
        $html = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(20, 10, 20, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('DNP');
        $html2pdf->writeHTML($html);
        $html2pdf->output('dnp-payroll-' . $payroll_id . '.pdf', 'D');
    }
}
