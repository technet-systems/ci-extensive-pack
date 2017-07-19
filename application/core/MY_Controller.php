<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    /**
     * Array variable to handle data between back-end classes
     * @var array
     */
    protected $data_app = array();

    public function __construct() {
        parent::__construct();

        // Dodanie 'template_from_string' do TWIGa
        // https://github.com/kenjis/codeigniter-ss-twig/issues/14
        // https://twig.sensiolabs.org/doc/1.x/functions/template_from_string.html
        $twig = $this->twig->getTwig();
        $twig->addExtension(new Twig_Extension_StringLoader());
    }
}