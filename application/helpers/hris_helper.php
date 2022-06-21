<?php

defined('BASEPATH') or exit('No direct script access allowed');

function hris()
{
    return [
        'token' => 'https://sso.kemenkeu.go.id/connect/',
        'body' => [
            'client_id' => 'alika.djkn',
            'client_secret' => '90bf0617c2fd45d5a35b288002fc9ece',
            'grant_type' => 'client_credentials'
        ],
        'hris' => 'https://service.kemenkeu.go.id/hris/'
    ];
}
