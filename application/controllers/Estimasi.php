<?php

class Estimasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
        $this->load->model('Data_sk_model', 'sk');
        $this->load->model('Data_biaya_model', 'biaya');
        $this->load->model('Data_pegawai_model', 'pegawai');
        $this->load->model('Ref_rute_model', 'rute');
        $this->load->model('Ref_sub_rute_model', 'subrute');
        $this->load->model('Ref_tarif_darat_model', 'tarif_darat');
        $this->load->model('Ref_packing_model', 'packing');
        $this->load->model('Ref_packing_model', 'packing');
        $this->load->model('Ref_provinsi_model', 'provinsi');
        $this->load->model('Ref_uang_harian_model', 'uang_harian');
        $this->load->model('Ref_pejabat_model', 'pejabat');
        $this->load->model('View_biaya_pegawai_model', 'biaya_pegawai');
        $this->load->model('Data_timeline_model', 'timeline');
        $this->load->model('Ref_darat_model', 'darat');
        $this->load->model('Ref_kubik_model', 'kubik');
    }

    private $rules = [
        [
            'field' => 'asal',
            'label' => 'asal',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'tujuan',
            'label' => 'tujuan',
            'rules' => 'required|trim'
        ]
    ];

    public function index()
    {
        $data['kdkawin'] = $this->db->query("SELECT distinct kdkawin FROM ref_kubik")->result_array();
        $data['gol'] = $this->db->query("SELECT distinct gol FROM ref_kubik")->result_array();
        $data['asal'] = $this->db->query("SELECT distinct asal FROM ref_rute")->result_array();
        $data['tujuan'] = $this->db->query("SELECT distinct tujuan FROM ref_rute")->result_array();

        $validation = $this->form_validation->set_rules($this->rules);

        if ($validation->run()) {
            // -- mulai hitung anggota keluarga
            $kdkawin = htmlspecialchars($this->input->post('kdkawin', true));
            $ybs = substr($kdkawin, 0, 1);
            $istri = substr($kdkawin, 1, 1);
            $anak = substr($kdkawin, 3, 1);
            $gol = htmlspecialchars($this->input->post('gol', true));
            $asal = htmlspecialchars($this->input->post('asal', true));
            $tujuan = htmlspecialchars($this->input->post('tujuan', true));
            $jumlah_anggota = $ybs + $istri + $anak;
            $jumlah_anggota_pesawat = $jumlah_anggota;
            $jumlah_kubik = $this->kubik->findJumlahKubik($gol, $kdkawin)['jumlah'];
            $ref_rute_id = $this->rute->findRute($asal, $tujuan, null, 0)[0]['id'];
            // tarik data tarif darat untuk tarif angkutan orang (2000) dan angkutan barang (400)
            $tarif_darat = $this->tarif_darat->getDetailTarifDarat(1);
            $tarif_orang = $tarif_darat['orang'];
            $tarif_barang = $tarif_darat['barang'];

            // hitung biaya angkutan sesuai jenis angkutan sesuai tabel subrute
            $subrute = $this->subrute->getRefRute($ref_rute_id);
            foreach ($subrute as $r) {
                $angkutan_id = $r['angkutan_id'];
                $ref_id = $r['ref_id'];
                // hitung tarif tiap jenis angkutan
                switch ($angkutan_id) {
                    case '1':
                        $pesawat = $this->subrute->getRefSubRute(1, $ref_id);
                        $data = [
                            'angkutan' => 'Pesawat',
                            'satuan' => $jumlah_anggota_pesawat,
                            'jarak' => '',
                            'tarif' => $pesawat['jumlah'],
                            'jumlah' => $jumlah_anggota_pesawat * $pesawat['jumlah'],
                            'uraian' => $pesawat['kota_asal'] . '-' . $pesawat['kota_tujuan']
                        ];
                        $hasil[] = $data;
                        break;
                    case '2':
                        $bus = $this->subrute->getRefSubRute(2, $ref_id);
                        $data = [
                            'angkutan' => 'Bus',
                            'satuan' => $jumlah_anggota_pesawat,
                            'jarak' => $bus['jumlah'],
                            'tarif' => $tarif_orang,
                            'jumlah' => $jumlah_anggota_pesawat * $bus['jumlah'] * $tarif_orang,
                            'uraian' => $bus['kota_asal'] . '-' . $bus['kota_tujuan']
                        ];
                        $hasil[] = $data;
                        break;
                    case '3':
                        $truk = $this->subrute->getRefSubRute(3, $ref_id);
                        if ($truk['sts'] == '1' and $truk['jumlah'] <= 50) {
                            $tarif = $tarif_barang * 0.5;
                        } else if ($truk['sts'] == '2' and $truk['jumlah'] <= 100) {
                            $tarif = $tarif_barang * 0.5;
                        } else {
                            $tarif = $tarif_barang;
                        }
                        $data = [
                            'angkutan' => 'Truk',
                            'satuan' => $jumlah_kubik,
                            'jarak' => $truk['jumlah'],
                            'tarif' => $tarif,
                            'jumlah' => $jumlah_kubik * $truk['jumlah'] * $tarif,
                            'uraian' => $truk['kota_asal'] . '-' . $truk['kota_tujuan']
                        ];
                        $hasil[] = $data;
                        break;
                    case '4':
                        $kapal = $this->subrute->getRefSubRute(4, $ref_id);
                        $data = [
                            'angkutan' => 'Kapal Laut',
                            'satuan' => $jumlah_kubik,
                            'jarak' => '',
                            'tarif' => $kapal['jumlah'],
                            'jumlah' => $jumlah_kubik * $kapal['jumlah'],
                            'uraian' => $kapal['kota_asal'] . '-' . $kapal['kota_tujuan']
                        ];
                        $hasil[] = $data;
                        break;
                    case '5':
                        $packing = $this->subrute->getRefSubRute(5, $ref_id);
                        $data = [
                            'angkutan' => 'Packing',
                            'satuan' => $jumlah_kubik,
                            'jarak' => '',
                            'tarif' => $packing['jumlah'],
                            'jumlah' => $jumlah_kubik * $packing['jumlah'],
                            'uraian' => $packing['kota_asal'] . '-' . $packing['kota_tujuan']
                        ];
                        $hasil[] = $data;
                        break;
                }
            }
            // hitung uang harian
            // cari data provinsi memakai data kota tujuan
            $provinsi = $this->provinsi->findProvinsi($tujuan, null, 0)[0]['provinsi'];
            // cari data uang harian memakai data provinsi
            $uang_harian = $this->uang_harian->findUangHarian($provinsi, null, 0)[0]['luar_kota'];
            $data = [
                'angkutan' => 'Uang Harian',
                'satuan' => $jumlah_anggota,
                'jarak' => 3,
                'tarif' => $uang_harian,
                'jumlah' => $jumlah_anggota * $uang_harian * 3,
                'uraian' => 'UANG HARIAN'
            ];
            $hasil[] = $data;
            $data['hasil'] = $hasil;
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('estimasi/hasil', $data);
            $this->load->view('template/footer');
        } else {
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('estimasi/index', $data);
            $this->load->view('template/footer');
        }
    }
}
