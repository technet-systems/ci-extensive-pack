<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends BACK_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        echo 'You are logged in!';
        var_dump($this->session->userdata());
        echo anchor($uri = 'back/auth/logout', $title = 'Log out');
    }
}