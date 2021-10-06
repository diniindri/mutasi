<?php

use GuzzleHttp\Client;

class Data_keluarga_model extends CI_Model
{
    private $_client;

    public function __construct()
    {
        $this->_client = new Client([
            'base_uri' => base_uri(),
            'verify' => false,
            'auth' => auth()
        ]);
    }

    public function getKeluarga($pegawai_id = null, $limit = null, $offset = 0)
    {
        $this->db->select('a.*,b.nama AS status_keluarga');
        $this->db->from('data_keluarga a');
        $this->db->join('ref_status_keluarga b', 'a.kdkeluarga=b.id', 'left');
        $this->db->where('pegawai_id', $pegawai_id);
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.kdkeluarga', 'asc');
        $this->db->order_by('a.tgllhr', 'asc');
        return $this->db->get()->result_array();
    }

    public function getDetailKeluarga($id = null)
    {
        return $this->db->get_where('data_keluarga', ['id' => $id])->row_array();
    }

    public function findKeluarga($pegawai_id = null, $nama = null, $limit = 0, $offset = 0)
    {
        $this->db->select('a.*,b.nama AS status_keluarga');
        $this->db->from('data_keluarga a');
        $this->db->join('ref_status_keluarga b', 'a.kdkeluarga=b.id', 'left');
        $this->db->where('a.pegawai_id', $pegawai_id);
        $this->db->limit($limit, $offset);
        $this->db->order_by('a.tgllhr', 'asc');
        $this->db->like('a.nama', $nama);
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    public function countKeluarga()
    {
        return $this->db->get('data_keluarga')->num_rows();
    }

    public function countKeluargaPegawai($pegawai_id = null)
    {
        return $this->db->get_where('data_keluarga', ['pegawai_id' => $pegawai_id])->num_rows();
    }

    public function createKeluarga($data = null)
    {
        $this->db->insert('data_keluarga', $data);
        return $this->db->affected_rows();
    }

    public function updateKeluarga($data = null, $id = null)
    {
        $this->db->update('data_keluarga', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteKeluarga($id = null)
    {
        $this->db->delete('data_keluarga', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllKeluarga()
    {
        $this->db->order_by('pegawai_id', 'DESC');
        return $this->db->get('data_keluarga')->result_array();
    }

    // data keluarga gaji
    public function findKeluargaGaji($keyword = null, $limit = 0, $offset = 0)
    {
        $response = $this->_client->request('GET', 'data-keluarga', [
            'query' => [
                'keyword' => $keyword,
                'limit' => $limit,
                'offset' => $offset,
                'X-API-KEY' => apiKey()
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function hitungInfant($pegawai_id)
    {
        return $this->db->get_where('data_keluarga', ['pegawai_id' => $pegawai_id, 'sts' => 1])->num_rows();
    }

    public function hitungArt($pegawai_id)
    {
        return $this->db->get_where('data_keluarga', ['pegawai_id' => $pegawai_id, 'kdkeluarga' => '4'])->num_rows();
    }
}
