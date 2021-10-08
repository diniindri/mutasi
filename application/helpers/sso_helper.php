<?php

defined('BASEPATH') or exit('No direct script access allowed');

function sso()
{
    return [
        'base_uri' => 'https://demo-account.kemenkeu.go.id/connect/',
        'authorize' => [
            'endpoint' => 'authorize',
            'grant_type' => 'authorization_code',
            'response_type' => 'code',
            'client_id' => 'alika.djkn',
            'scope' => 'profile openid gateway jabatan.hris',
            'nonce' => '123456',
            'state' => '123456',
            'redirect_uri' => 'http://10.10.1.76/v2021/sso'
        ],
        'token' => [
            'endpoint' => 'token',
            'client_secret' => '3d8504960ad348a09c5a1aecd1373927'
        ],
        'userinfo' => [
            'endpoint' => 'userinfo'
        ],
        'endsession' => [
            'endpoint' => 'endsession'
        ]
    ];
}
