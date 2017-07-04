<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends BACK_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->model('page_m');
        $this->load->model('menu_m');
    }

    public function index() {
        redirect('back/setup/menu');
    }

    public function menu() {
        $this->data_back['pages'] = $this->page_m->order_by('pa_order', 'ASC')->get_all();
        $this->data_back['menu_items'] = $this->menu_m->order_by('me_order', 'ASC')->get_all();

        $this->twig->display('back/setup/menu_v', $this->data_back);
    }

    public function save_menu_item($me_id = FALSE) {
        if($me_id) {
            $rules = $this->menu_m->rules['update'];

            $this->form_validation->set_rules($rules);

            if($this->form_validation->run()) {
                $this->menu_m->update(array(
                    'me_title_alt' =>  $_POST['me_title_alt'],
                    'me_updated_by' => $this->data_back['us_id']
                ), $me_id);

                // Update 'parent_id' stron
                $actual_menu_items = $this->page_m->where('pa_me_id', $me_id)->get_all(); // Uzyskanie wszystkich stron z danym Parent ID (pa_me_id)

                foreach ($actual_menu_items as $actual_menu_item) { // Ustawienie dla wybranych stron Parent ID (pa_me_id) na NULL
                    $this->page_m->update(array(
                        'pa_me_id' => NULL
                    ), $actual_menu_item->pa_id);
                }

                //var_dump($actual_menu_items);die();

                foreach ($_POST['pa_id'] as $key => $value) {
                    $this->page_m->update(array(
                        'pa_order' => $key,
                        'pa_me_id' => $me_id,
                        'pa_updated_by' => $this->data_back['us_id']
                    ), $value);
                }
                // /Update 'parent_id' stron

                $this->session->set_flashdata('success', 'Zmieniono element menu');
                redirect('back/setup/menu');
            } else {
                $this->menu();
            }
        } else {
            // Rozróżnienie jaki formularz został przesłany (w zależności od elementu hidden w formularzu)
            if($_POST['form-name'] == 'nav-site') {

                //var_dump($_POST['form-name']);die();

                // Setting $_POST variables into the rules array
                $rules = $this->menu_m->rules['create'][$_POST['form-name']];

                $this->form_validation->set_rules($rules);

                if($this->form_validation->run()) {
                    // Zwrócenie danych strony po jej slug'u
                    $page = $this->page_m->where('pa_slug', $_POST['me_pa_slug'])->get();

                    $this->menu_m->insert(array(
                        'me_title' => $page->pa_title,
                        'me_title_alt' => $page->pa_title,
                        'me_order' => $this->menu_m->count_menu_items(),
                        'me_created_by' => $this->data_back['us_id'],
                        'me_pa_slug' => $_POST['me_pa_slug']
                    ));

                    $this->session->set_flashdata('success', 'Dodano nowy element do menu');
                    redirect('back/setup/menu');
                } else {
                    $this->menu();
                }

            } elseif ($_POST['form-name'] == 'nav-anchor') {
                // Setting $_POST variables into the rules array
                $rules = $this->menu_m->rules['create'][$_POST['form-name']];

                $this->form_validation->set_rules($rules);

                if($this->form_validation->run()) {
                    $this->menu_m->insert(array(
                        'me_title' => $_POST['me_title'],
                        'me_title_alt' => $_POST['me_title'],
                        'me_link' => $_POST['me_link'],
                        'me_order' => $this->menu_m->count_menu_items(),
                        'me_created_by' => $this->data_back['us_id'],
                    ));

                    $this->session->set_flashdata('success', 'Dodano nowy element do menu');
                    redirect('back/setup/menu');
                } else {
                    $this->menu();
                }
            }

        }
    }

    public function delete_menu_item($me_id) {
        // TODO usunięcie elementu menu

        if(!is_int($me_id)) {
            $this->menu_m->delete($me_id);
            $this->session->set_flashdata('success', 'Usunięto element menu');
            redirect('back/setup/menu');
        } else {
            $this->session->set_flashdata('error', 'Coś poszło nie tak');
            redirect('back/setup/menu');
        }
    }

    public function update_nestable() {
        $sorted_list = json_decode($_POST['output']);

        foreach ($sorted_list as $key => $value) {
            $this->menu_m->update(array('me_order' => $key), $value->id);
        }

    }

    public function inline_update() {
        // assignment of variables
        $value  = $this->input->post('value');
        $name   = $this->input->post('name');
        $pk     = $this->input->post('pk');

        // For proper rules check in '$this->form_validation->run()' method
        $_POST[$name] = $value;

        // Setting rules
        $this->form_validation->set_rules($this->page_m->rules['inline-update'][$name]);

        // Validation process
        if($this->form_validation->run()) {
            // Update the data
            $this->page_m->update(array(
                $name => $value,
                'pa_updated_by' => $this->data_back['us_id']
            ), $pk);
            echo json_encode(array('status' => 1, 'msg' => 'Zmieniono dane'));
        } else {
            $this->form_validation->set_error_delimiters('', '');
            echo json_encode(array('status' => 0, 'msg' => validation_errors()));
        }
    }

    public function delete_menu_sub_item($pa_id) {
        if(!is_int($pa_id)) {
            $this->page_m->update(array(
                'pa_me_id' => NULL,
                'pa_updated_by' => $this->data_back['us_id']
            ), $pa_id);
            $this->session->set_flashdata('success', 'Usunięto podrzędny element z menu');
            redirect('back/setup/menu');
        } else {
            $this->session->set_flashdata('error', 'Coś poszło nie tak');
            redirect('back/setup/menu');
        }
    }
}