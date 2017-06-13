<?php

class BACK_Controller extends MY_Controller {
    protected $data_back = array();

    public function __construct()
    {
        parent::__construct();
        // Adding global variable for display flash data in TWIG
        $this->twig->addGlobal('session', $this->session);

        // Loading the user_m for checking if the user is still logged in
        $this->load->model('user_m');

        // Adding configurations items to $this->data_back() array
        $this->data_back['app_name'] = config_item('app_name');
        $this->data_back['app_ver'] = config_item('app_ver');
        $this->data_back['app_description'] = config_item('app_description');

        //var_dump($this->data_back);die();

        // Checking if the user is on the specific URL and no redirect when he isn't logged in
        $exception_uris = [
            'back/auth',
            'back/auth/reset',
            'back/auth/logout'
        ];

        // If he isn't than check if he is logged in
        if(in_array(uri_string(), $exception_uris) == FALSE) {
            // If NOT then redirect to auth with a proper message
            if($this->user_m->loggedin() == FALSE) {
                $this->session->set_flashdata('error', 'Wylogowano użytkownika, zaloguj się ponownie.'); // Set flash message to the user
                redirect('back/auth');
            } else {
                // If YES then add all session data elements to $this->data
                foreach ($this->session->userdata as $key => $value) { // Za pomocą pętli dodajemy wszystkie dane logowania
                    $this->data_back[$key] = $value;
                }
            }
        }
    }
}