<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Administration extends BACK_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function user() {
        // Setting $_POST variables into the rules array
        $rules = $this->user_m->rules['create'];

        $this->form_validation->set_rules($rules);

        if($this->form_validation->run()) {
            $us_pass = $this->user_m->hash_salt($this->input->post('us_pass'));

            $this->user_m->from_form($rules, array('us_pass' => $us_pass, 'us_pass_temp' => $us_pass, 'us_created_by' => $this->data_back['us_id']))->insert();

            $this->session->set_flashdata('success', 'Dodano nowego użytkownika');
            redirect('back/administration/user');
        }

        // Fetch users depending on permissions stored in session['us_auth]
        $this->data_back['users'] = $this->user_m->get_all_users();
        $this->twig->display('back/administration/user_v', $this->data_back);
    }

    public function inline_update() {
        // assignment of variables
        $value  = $this->input->post('value');
        $name   = $this->input->post('name');
        $pk     = $this->input->post('pk');

        // For proper rules check in '$this->form_validation->run()' method
        $_POST[$name] = $value;

        // Setting rules
        $this->form_validation->set_rules($this->user_m->rules['inline-update'][$name]);

        // Validation process
        if($this->form_validation->run()) {
            // Checking is the input field name is a password and setting the '$this->data_back['us_pass_temp']' to FALSE
            $name != 'us_pass' || $value = $this->user_m->hash_salt($value); $this->session->userdata['us_pass_temp'] = FALSE;

            // Update the data
            $this->user_m->update(array(
                $name => $value,
                'us_updated_by' => $this->data_back['us_id']
            ), $pk);
            echo json_encode(array('status' => 1, 'msg' => 'Zmieniono dane'));
        } else {
            $this->form_validation->set_error_delimiters('', '');
            echo json_encode(array('status' => 0, 'msg' => validation_errors()));
        }
    }
}