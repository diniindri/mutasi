<?php

use GuzzleHttp\Client;

class Data_hris_model extends CI_Model
{
    private $_client1;
    private $_client2;

    public function __construct()
    {
        $this->load->helper('hris');
        $this->_client1 = new Client([
            'base_uri' => hris()['token'],
            'verify' => false
        ]);
        $this->_client2 = new Client([
            'base_uri' => hris()['hris'],
            'verify' => false
        ]);
    }

    public function getToken()
    {
        $response = $this->_client1->request('POST', 'token', [
            'form_params' => [
                'client_id' => hris()['body']['client_id'],
                'client_secret' => hris()['body']['client_secret'],
                'grant_type' => hris()['body']['grant_type']
            ]
        ]);
        $token = json_decode($response->getBody()->getContents(), true);
        return $token['access_token'];
    }

    public function getProfil($nip = null)
    {
        $response = $this->_client2->request('GET', 'profil/Pegawai/GetByNip/' . $nip . '', [
            'headers' => [
                'authorization' => 'Bearer ' . $this->getToken()
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getKeluarga($nip = null)
    {
        $response = $this->_client2->request('GET', 'keluarga/Riwayat/GetKeluargaByNip/' . $nip . '', [
            'headers' => [
                'authorization' => 'Bearer ' . $this->getToken()
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
