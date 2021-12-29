<?php

use Spipu\Html2Pdf\Html2Pdf;

class Monitoring_dokumen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        // meload file Data_sk_model.php
        $this->load->model('Data_sk_model', 'sk');
        $this->load->model('Data_upload_model', 'dataupload');
        $this->load->model('Data_pegawai_model', 'pegawai');
        $this->load->model('Ref_dokumen_model', 'dokumen');
        $this->load->model('Data_timeline_model', 'timeline');
        $this->load->model('View_pegawai_sk_model', 'pegawai_sk');
        $this->load->model('Ref_pejabat_model', 'pejabat');
        $this->load->model('Ref_laporan_model', 'laporan');
        $this->load->model('Data_biaya_model', 'biaya');
        $this->load->model('Data_keluarga_model', 'keluarga');
    }

    public function index()
    {

        // menangkap data pencarian uraian sk
        $uraian = $this->input->post('uraian');

        // settingan halaman
        $config['base_url'] = base_url('biaya-mutasi/index');
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
        $this->load->view('monitoring_dokumen/index', $data);
        $this->load->view('template/footer');
    }

    public function detail($sk_id = null)
    {
        // cek apakah ada sk id apa tidak
        if (!isset($sk_id)) show_404();

        // mengirim data id sk ke view
        $data['sk_id'] = $sk_id;

        // menangkap data pencarian nmpeg
        $nmpeg = $this->input->post('nmpeg');

        // settingan halaman
        $config['base_url'] = base_url('monitoring-dokumen/detail/' . $sk_id . '');
        $config['total_rows'] = $this->pegawai->countPegawaiMutasi($sk_id);
        $config['per_page'] = 10;
        $config["num_links"] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['page'] = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
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
        $this->load->view('monitoring_dokumen/detail', $data);
        $this->load->view('template/footer');
    }

    public function download($sk_id = null, $pegawai_id = null)
    {
        $data['download'] = [
            ['nama' => 'Rincian Biaya', 'url' => '' . base_url() . 'monitoring-dokumen/download-biaya/' . $sk_id . '/' . $pegawai_id . ''],
            ['nama' => 'SPD', 'url' => '' . base_url() . 'monitoring-dokumen/download-spd/' . $sk_id . '/' . $pegawai_id . '']
        ];
        // meload view pada pegawai/index.php
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('monitoring_dokumen/download', $data);
        $this->load->view('template/footer');
    }

    public function download_spd($sk_id = null, $pegawai_id = null)
    {
        if (!isset($sk_id)) show_404();

        $data['dokumen'] = $this->dokumen->getAllDokumen();
        $kode = $this->input->post('kode');
        $data['sk_id'] = $sk_id;
        $data['pegawai_id'] = $pegawai_id;

        $data['ppk'] = $this->pejabat->getKodePejabat(1);
        $data['pegawai'] = $this->pegawai->getDetailPegawai($pegawai_id);
        $data['keluarga'] = $this->keluarga->getKeluarga($pegawai_id);
        $data['detail_sk'] = $this->pegawai_sk->getDetailPegawaiSk($pegawai_id);
        $data['laporan'] = $this->laporan->getDetailLaporan(1);
        ob_start();
        $this->load->view('monitoring_dokumen/spd', $data);
        $html = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(20, 10, 20, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('SPD');
        $html2pdf->writeHTML($html);
        $html2pdf->output('spd-' . '.pdf');
    }

    public function download_biaya($sk_id = null, $pegawai_id = null)
    {
        if (!isset($sk_id)) show_404();

        $data['dokumen'] = $this->dokumen->getAllDokumen();
        $kode = $this->input->post('kode');
        $data['sk_id'] = $sk_id;
        $data['pegawai_id'] = $pegawai_id;

        $data['ppk'] = $this->pejabat->getKodePejabat(1);
        $data['bendahara'] = $this->pejabat->getKodePejabat(2);
        $data['pegawai'] = $this->pegawai->getDetailPegawai($pegawai_id);
        $data['laporan'] = $this->laporan->getDetailLaporan(1);
        $data['biaya_orang'] = $this->biaya->getRincianBiayaPerJenis($pegawai_id, 1);
        $data['biaya_barang'] = $this->biaya->getRincianBiayaPerJenis($pegawai_id, 2);
        $data['biaya_lumpsum'] = $this->biaya->getRincianBiayaPerJenis($pegawai_id, 3);
        ob_start();
        $this->load->view('monitoring_dokumen/biaya', $data);
        $html = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'en', false, 'UTF-8', array(20, 10, 20, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('Biaya');
        $html2pdf->writeHTML($html);
        $html2pdf->output('biaya-' . '.pdf');
    }

    public function upload($sk_id = null, $pegawai_id = null)
    {
        if (!isset($sk_id)) show_404();

        $data['dokumen'] = $this->dokumen->getAllDokumen();
        $kode = $this->input->post('kode');
        $data['sk_id'] = $sk_id;
        $data['pegawai_id'] = $pegawai_id;

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
                    //simpan data ke tabel data_upload
                    $data = [
                        'pegawai_id' => $pegawai_id,
                        'kode' => $kode,
                        'date_created' => time()
                    ];
                    $this->dataupload->createUpload($data);
                    // rekam data_timeline
                    // cek apakah sudah ada data apa belum
                    switch ($kode) {
                        case '1':
                            $proses_id = '2';
                            $keterangan = 'Pegawai telah melakukan upload dokumen KP4 yang sudah disahkan oleh Pejabat yang berwenang';
                            break;
                        case '2':
                            $proses_id = '5';
                            $keterangan = 'Pegawai telah melakukan upload dokumen rincian biaya mutasi yang sudah ditandatangani';
                            break;
                        case '3':
                            $proses_id = '6';
                            $keterangan = 'Pegawai telah melakukan upload dokumen SPD yang sudah ditandatangani oleh Pejabat yang berwenang pada Kantor asal';
                            break;
                        case '4':
                            $proses_id = '7';
                            $keterangan = 'Pegawai telah melakukan upload dokumen SPD yang sudah ditandatangani oleh Pejabat yang berwenang pada Kantor tujuan';
                            break;
                        default:
                            $proses_id = '11';
                            $keterangan = 'Pegawai telah melakukan upload dokumen KTP ART';
                            break;
                    }

                    $data_timeline = [
                        'pegawai_id' => $pegawai_id,
                        'proses_id' => $proses_id,
                        'keterangan' => $keterangan,
                        'tanggal' => time()
                    ];
                    if ($this->timeline->cekTimeline($pegawai_id, $proses_id)) {
                        $this->timeline->updateTimeline($data_timeline, $pegawai_id, $proses_id);
                    } else {
                        $this->timeline->createTimeline($data_timeline);
                    }
                    // selesai
                    redirect('monitoring-dokumen/detail/' . $sk_id . '');
                } else {
                    echo $this->upload->display_errors();
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Upload file gagal, mohon menggunakan format file pdf dan ukuran maksimal 10 MB!</div>');
                    redirect('monitoring-dokumen/upload/' . $sk_id . '/' . $pegawai_id . '');
                }
            }
        }

        // form
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('monitoring_dokumen/upload', $data);
        $this->load->view('template/footer');
    }

    public function hapus($sk_id = null, $pegawai_id = null)
    {
        $data['dokumen'] = $this->dataupload->getPegawaiUpload($pegawai_id);
        $data['sk_id'] = $sk_id;
        $data['pegawai_id'] = $pegawai_id;

        // form
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('monitoring_dokumen/hapus', $data);
        $this->load->view('template/footer');
    }

    public function delete($sk_id = null, $pegawai_id = null, $id = null, $file = null)
    {
        // cek apakah ada id apa tidak
        if (!isset($id)) show_404();
        // hapus data di database melalui model
        if ($this->dataupload->deleteUpload($id)) {
            unlink('assets/files/' . $file);
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus.');
        }
        redirect('monitoring-dokumen/hapus/' . $sk_id . '/' . $pegawai_id . '');
    }
}
