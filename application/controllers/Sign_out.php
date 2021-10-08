<?php

class Sign_out extends CI_Controller
{
    public function index()
    {
        $this->session->sess_destroy();

        $uri = sso()['base_uri'] . sso()['endsession']['endpoint'];
        $id_token = $this->session->userdata('id_token');
        $post_logout_redirect_uri = sso()['authorize']['redirect_uri'];
        $state = sso()['authorize']['state'];
        $endsession_url = $uri . '?id_token_hint=' . $id_token . '&post_logout_redirect_uri=' . $post_logout_redirect_uri . '&state=' . $state;

        redirect($endsession_url);
    }
}
