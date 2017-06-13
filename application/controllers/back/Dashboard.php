<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends BACK_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        redirect('back/dashboard/overview');
    }

    public function overview() {
        // Checking if user has a temporary password set
        !$this->data_back['us_pass_temp'] || $this->session->set_flashdata('warning', 'Zmień swoje tymczasowe hasło na własne');

        $this->twig->display('back/dashboard/overview_v', $this->data_back);
    }
}