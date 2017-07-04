<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends BACK_Controller {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Checking if the user has already a session set or gave proper login credetials
     * Displays the login view
     */
    public function index() {
        // Check if the user is already logged in
        if($this->user_m->loggedin()) {
            redirect('back/dashboard');
        } else {
            // Setting $_POST variables into the rules array
            $this->form_validation->set_rules($this->user_m->rules['login']);

            // Let's run the validation
            if($this->form_validation->run()) {
                // If email/pass are correct then redirect to dashboard
                if($this->user_m->login()) {
                    redirect('back/dashboard');

                // If not than set and print a flash data on the login page
                } else {
                    $this->session->set_flashdata('error', 'Niepoprawny e-mail i/lub hasło');
                    redirect('back/auth');
                }
            }
        }

        // Destroy the current session and display it in the proper view
        $this->session->sess_destroy();
        $this->twig->display('back/auth/index_v', $this->data_back);
    }

    /**
     * Logout method that is setting the loggedin key to FALSE, and redirect to login page with a proper flash data message
     */
    public function logout() {
        $this->session->unset_userdata('loggedin');
        $this->session->set_flashdata('success', 'Bezpiecznie wylogowano');
        redirect('back/auth');
    }

    /**
     * Reset password method
     */
    public function reset() {
        // Setting $_POST variables into the rules array
        $this->form_validation->set_rules($this->user_m->rules['reset']);

        // Let's run the validation
        if($this->form_validation->run()) {
            $this->user_m->reset();

            $this->session->set_flashdata('success', 'Sprawdź e-maila z tymczasowym hasłem');
            redirect('back/auth');
        }

        $this->twig->display('back/auth/reset_v');
    }
}