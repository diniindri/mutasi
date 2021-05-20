<?php

use GuzzleHttp\Client;

class Sso extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->_client = new Client([
            'base_uri' => sso()['base_uri'],
            'verify' => false
        ]);
    }

    public function index()
    {
        if ($_GET['code']) {

            // get token
            $response = $this->_client->request('POST', sso()['token']['endpoint'], [
                'form_params' => [
                    'client_id' => sso()['authorize']['client_id'],
                    'grant_type' => sso()['authorize']['grant_type'],
                    'client_secret' => sso()['token']['client_secret'],
                    'code' => $_GET['code'],
                    'redirect_uri' => sso()['authorize']['redirect_uri']
                ]
            ]);
            $token =  json_decode($response->getBody()->getContents(), true);

            // get user info
            $access_token = $token['access_token'];
            if ($access_token) {
                $response = $this->_client->request('POST', sso()['userinfo']['endpoint'], [
                    'form_params' => [
                        'access_token' => $access_token
                    ]
                ]);
                $userinfo =  json_decode($response->getBody()->getContents(), true);

                $newdata = [
                    'nip' => $userinfo['nip'],
                    'id_token' => $token['id_token']
                ];
                $this->session->set_userdata($newdata);
                redirect('beranda');
            } else {
                redirect('welcome');
            }
        } else {
            redirect('welcome');
        }
    }
}

// class Sso extends CI_Controller
// {
//     public function index()
//     {
//         if ($_GET['code']) {
//             $code = $_GET['code'];
//             $source_1 = file_get_contents("https://sso.djkn.kemenkeu.go.id/via/sso/remote/get_access_token?client_id=portalkeuangan&code=$code");
//             $token = json_decode($source_1, true);
//             $token = $token['access_token'];
//             $source_2 = file_get_contents("https://sso.djkn.kemenkeu.go.id/via/sso/remote/get_user_data?client_id=portalkeuangan&client_secret=kudsayfiu3f3u97fhaiuewfkhgfoi&access_token=$token");
//             $data = json_decode($source_2, true);
//             $newdata = [
//                 'nama' => $data['nama'],
//                 'nip' => $data['nip']
//             ];
//             $this->session->set_userdata($newdata);
//             redirect('beranda');
//         } else {
//             redirect('welcome');
//         }
//     }
// }
