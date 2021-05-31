<?php

defined('BASEPATH') or exit('No direct script access allowed');

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('nip')) {
        redirect('welcome');
    }
}

function base_uri()
{
    $base_uri = 'https://alika.kemenkeu.go.id/api/';
    // $base_uri = 'http://localhost:8888/x-alika/api/';
    return $base_uri;
}

function auth()
{
    $auth = ['superalika', 'Hkkg456*#@ghj@#jkkknb4578HrtgJgffg875hfg&kjkh*hgf*gff@fghjjYbbh654g6sh6sj8253nsg6j*hnb#'];
    return $auth;
}

function apiKey()
{
    return 'hGfdg456ghD4f566afjh6Fg@hgb#jijk';
}
