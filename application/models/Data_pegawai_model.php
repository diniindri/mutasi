<?php

use GuzzleHttp\Client;

class Data_pegawai_model extends CI_Model
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

    public function getPegawai($sk_id = null, $limit = 0, $offset = 0)
    {
        $this->db->where('sk_id', $sk_id);
        $this->db->limit($limit, $offset);
        return $this->db->get('data_pegawai')->result_array();
    }

    public function getDetailPegawai($id = null)
    {
        return $this->db->get_where('data_pegawai', ['id' => $id])->row_array();
    }

    public function findPegawai($sk_id = null, $nmpeg = null, $limit = 0, $offset = 0)
    {
        $this->db->like('nmpeg', $nmpeg);
        $this->db->limit($limit, $offset);
        return $this->db->get_where('data_pegawai', ['sk_id' => $sk_id])->result_array();
    }

    public function countPegawai()
    {
        return $this->db->get('data_pegawai')->num_rows();
    }

    public function createPegawai($data = null)
    {
        $this->db->insert('data_pegawai', $data);
        return $this->db->affected_rows();
    }

    public function updatePegawai($data = null, $id = null)
    {
        $this->db->update('data_pegawai', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deletePegawai($id = null)
    {
        $this->db->delete('data_pegawai', ['id' => $id]);
        return $this->db->affected_rows();
    }

    // data pegawai gaji

    public function getPegawaiGaji($id = null, $limit = 0, $offset = 0)
    {
        $response = $this->_client->request('GET', 'data-pegawai', [
            'query' => [
                $id === null ?: 'id' => $id,
                'limit' => $limit,
                'offset' => $offset,
                'X-API-KEY' => apiKey()
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function findPegawaiGaji($keyword = null, $limit = 0, $offset = 0)
    {
        $response = $this->_client->request('GET', 'data-pegawai', [
            'query' => [
                'keyword' => $keyword,
                'limit' => $limit,
                'offset' => $offset,
                'X-API-KEY' => apiKey()
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function countPegawaiGaji()
    {
        $response = $this->_client->request('GET', 'count-data-pegawai', [
            'query' => [
                'X-API-KEY' => apiKey()
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
