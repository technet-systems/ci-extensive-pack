<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    /**
     * Array variable to handle data between back-end classes
     * @var array
     */
    protected $data = array();

    public function __construct() {
        parent::__construct();
    }
}