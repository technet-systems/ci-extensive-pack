<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends BACK_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->model('page_m');
        $this->load->model('module_m');
        $this->load->model('file_m');

        $this->load->library('image_lib');

        $this->data_back['layouts'] = get_filenames(APPPATH.'views/build/layout/');
    }

    public function page() {
        // Setting $_POST variables into the rules array
        $rules = $this->page_m->rules['create'];

        $this->form_validation->set_rules($rules);

        if($this->form_validation->run()) {
            $slug = $this->page_m->create_slug($this->input->post('pa_title'));

            $this->page_m->from_form($rules, array('pa_title_alt' => $this->input->post('pa_title'), 'pa_slug' => $slug, 'pa_created_by' => $this->data_back['us_id']))->insert();

            $this->session->set_flashdata('success', 'Dodano nową stronę');
            redirect('back/content/page');
        }

        // Fetch users depending on permissions stored in session['us_auth]
        $this->data_back['pages'] = $this->page_m->get_all_pages();

        $this->twig->display('back/content/page_v', $this->data_back);
    }

    public function edit($id) {
        if(!is_int($id)) {
            if($_POST) {
                // Check for the particular module name
                $check_module_name = explode('-', $_POST['mo_layout']);

                if($check_module_name[0] == 'Galeria') {
                    $rules = $this->module_m->rules['create'][$_POST['mo_layout']];

                    $this->form_validation->set_rules($rules);

                    if($this->form_validation->run()) {

                        $var_images = $_POST['var-image'];
                        $files = array();
                        foreach ($var_images as $key => $value) {
                            $value = explode('.', $value); // Odseparowanie nazwy pliku od rozszerzenia
                            $files[$key] = $this->file_m->where('fi_name', $value[0])->as_array()->get();
                        }

                        $this->module_m->insert(array(
                            'mo_variables' => json_encode($files), // json encode in order to store the files in the DB
                            'mo_form' => $this->module_m->create_dynamic_editable_form($files, $_POST['mo_layout']),
                            'mo_layout' => $_POST['mo_layout'],
                            'mo_body' => $this->module_m->parse_dynamic_form_to_html($files, $_POST['mo_layout']),
                            'mo_description' => $_POST['mo_description'],
                            'mo_order' => $this->module_m->count_modules($_POST['mo_layout'], $id),
                            'mo_created_by' => $this->data_back['us_id'],
                            'mo_pa_id' => $id
                        ));

                        $this->session->set_flashdata('success', 'Dodano nowy moduł');
                        redirect('back/content/edit/' . $id);

                    }
                } else {
                    $rules = $this->module_m->rules['create'][$_POST['mo_layout']];

                    $this->form_validation->set_rules($rules);

                    if($this->form_validation->run()) {
                        $mo_variables = array(); // Tablica na zmienne z formularza modułu

                        // Checking if the $_POST key starts with 'var'
                        foreach ($_POST as $key => $value) {
                            if(strpos($key, 'var') !== false) {
                                $mo_variables[$key] = $value;

                                unset($_POST[$key]);
                            }
                        }

                        // json encode in order to store the variables in the DB
                        $mo_variables = json_encode($mo_variables);

                        $this->module_m->insert(array(
                            'mo_variables' =>  $mo_variables,
                            'mo_form' => $this->module_m->create_editable_form($mo_variables, $_POST['mo_layout']),
                            'mo_layout' => $_POST['mo_layout'],
                            'mo_body' => $this->module_m->parse_form_to_html($mo_variables, $_POST['mo_layout']),
                            'mo_description' => $_POST['mo_description'],
                            'mo_order' => $this->module_m->count_modules($_POST['mo_layout'], $id),
                            'mo_created_by' => $this->data_back['us_id'],
                            'mo_pa_id' => $id
                        ));

                        $this->session->set_flashdata('success', 'Dodano nowy moduł');
                        redirect('back/content/edit/' . $id);
                    }
                }


            }

            $this->data_back['test'] = $this->module_m->get(28);

            $this->data_back['page']    = $this->page_m->get($id);

            $this->data_back['layouts'] = $this->page_m->get_layouts();

            $this->data_back['files'] = $this->file_m->order_by('fi_created_at', 'DESC')->get_all();

            $this->data_back['forms']   = $this->page_m->get_forms();

            $this->data_back['modules'] = $this->module_m->where('mo_pa_id', $id)->order_by('mo_order', 'ASC')->get_all();

            //var_dump(json_decode($mo_variables));die();

            $this->twig->display('back/content/page_edit_v', $this->data_back);
        } else {
            $this->session->set_flashdata('error', 'Nie znalazłem żądanej strony');
            redirect('back/content/page');
        }
    }

    public function update_nestable() {
        $sorted_list = json_decode($_POST['output']);
        foreach ($sorted_list as $key => $value) {
            $this->module_m->update(array('mo_order' => $key), $value->id);
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
            // Checking is the input field name is a password and setting the '$this->data_back['us_pass_temp']' to FALSE
            $name != 'pa_slug' || $value = $this->page_m->create_slug($value);

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

    public function delete($id) {
        if(!is_int($id)) {
            $this->page_m->delete($id);
            $this->session->set_flashdata('success', 'Usunięto stronę');
            redirect('back/content/page');
        } else {
            $this->session->set_flashdata('error', 'Coś poszło nie tak');
            redirect('back/content/page');
        }
    }

    public function edit_module($mo_id) {
        if(!is_int($mo_id)) {
            if($_POST) {
                // Check for the particular module name
                $check_module_name = explode('-', $_POST['mo_layout']);

                if($check_module_name[0] == 'Galeria') {
                    $rules = $this->module_m->rules['update'][$_POST['mo_layout']];

                    $this->form_validation->set_rules($rules);

                    if($this->form_validation->run()) {
                        $var_images = $_POST['var-image'];
                        $files = array();
                        foreach ($var_images as $key => $value) {
                            $value = explode('.', $value); // Odseparowanie nazwy pliku od rozszerzenia
                            $files[$key] = $this->file_m->where('fi_name', $value[0])->as_array()->get();
                        }

                        $this->module_m->update(array(
                            'mo_variables' =>  json_encode($files),
                            'mo_form' => $this->module_m->create_dynamic_editable_form($files, $_POST['mo_layout']),
                            'mo_body' => $this->module_m->parse_dynamic_form_to_html($files, $_POST['mo_layout']),
                            'mo_description' => $_POST['mo_description'],
                            'mo_updated_by' => $this->data_back['us_id']
                        ), $mo_id);

                        $this->session->set_flashdata('success', 'Zaktualizowano moduł');
                        redirect('back/content/edit/' . $_POST['mo_pa_id']);
                    }
                } else {
                    $rules = $this->module_m->rules['update'][$_POST['mo_layout']];

                    $this->form_validation->set_rules($rules);

                    if($this->form_validation->run()) {
                        $mo_variables = array();

                        // Checking if the $_POST key starts with 'var'
                        foreach ($_POST as $key => $value) {
                            if(strpos($key, 'var') !== false) {
                                $mo_variables[$key] = $value;

                                unset($_POST[$key]);
                            }
                        }

                        //var_dump($mo_variables);die();

                        // json encode in order to store the variables in the DB
                        $mo_variables = json_encode($mo_variables);

                        //var_dump(json_decode($mo_variables), TRUE);die();

                        $this->module_m->update(array(
                            'mo_variables' =>  $mo_variables,
                            'mo_form' => $this->module_m->create_editable_form($mo_variables, $_POST['mo_layout']),
                            'mo_body' => $this->module_m->parse_form_to_html($mo_variables, $_POST['mo_layout']),
                            'mo_description' => $_POST['mo_description'],
                            'mo_updated_by' => $this->data_back['us_id']
                        ), $mo_id);

                        $this->session->set_flashdata('success', 'Zaktualizowano moduł');
                        redirect('back/content/edit/' . $_POST['mo_pa_id']);
                    }
                }
            }

            $this->data_back['page']    = $this->page_m->get($id);

            $this->data_back['layouts'] = $this->page_m->get_layouts();

            $this->data_back['forms']   = $this->page_m->get_forms();

            $this->data_back['modules'] = $this->module_m->where('mo_pa_id', $id)->order_by('mo_order', 'ASC')->get_all();

            //var_dump(json_decode($mo_variables));die();

            $this->twig->display('back/content/page_edit_v', $this->data_back);
        } else {
            $this->session->set_flashdata('error', 'Nie znalazłem żądanego modułu');
            redirect('back/content/page');
        }
    }

    public function delete_module($mo_pa_id, $mo_id) {
        if(!is_int($mo_id)) {
            $this->module_m->delete($mo_id);
            $this->session->set_flashdata('success', 'Usunięto moduł');
            redirect('back/content/edit/' . $mo_pa_id);
        } else {
            $this->session->set_flashdata('error', 'Coś poszło nie tak');
            redirect('back/content/edit/' . $mo_pa_id);
        }
    }

    public function media() {
        if($this->upload->do_upload('uploadedfiles')) {
            // Uzyskanie nazwy pliku http://stackoverflow.com/questions/16345761/codeigniter-get-the-uploaded-file-name


            // Returns array of containing all of the data related to the file you uploaded depends if there was uploaded only 1 file or more
            // https://stackoverflow.com/questions/145337/checking-if-array-is-multidimensional-or-not
            if(count($this->upload->data()) == count($this->upload->data(), COUNT_RECURSIVE)) {
                // Dla uploadowanego 1 pliku tworzymy specjalnie tablicę wielowymiarową
                $upload_files[0] = $this->upload->data();
                $message = 'Dodano nowy plik';
            } else {
                // Dla większej ilości plików pozostawiamy tablicę bez zmian (bo dla 2 i więcej uploadowanych plików jest ona już domyślnie wielowymiarowa)
                $upload_files = $this->upload->data();
                $message = 'Dodano nowe pliki';
            }

            foreach ($upload_files as $upload_file) {
                // Create thumb
                // Używanie biblioteki do manipulacji zdjęciami w pętli foreach https://stackoverflow.com/questions/19218247/codeigniter-image-resize
                $config['image_library']    = 'gd2';
                $config['source_image']     = $upload_file['full_path'];
                $config['create_thumb']     = TRUE;
                $config['maintain_ratio']   = TRUE;
                $config['width']            = 150;
                $config['height']           = 150;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $this->file_m->insert(array(
                    'fi_name'       => $upload_file['raw_name'],
                    'fi_name_thumb' => $upload_file['raw_name'] . '_thumb',
                    'fi_orig_name'  => strtolower($upload_file['orig_name']),
                    'fi_extension'  => strtolower($upload_file['file_ext']),
                    'fi_type'       => $upload_file['image_type'],
                    'fi_size'       => $upload_file['file_size'],
                    'fi_width'      => $upload_file['image_width'],
                    'fi_height'     => $upload_file['image_height'],
                    'fi_created_by' => $this->data_back['us_id']
                ));

            }

            $this->session->set_flashdata('success', $message);
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        }

        $this->data_back['files'] = $this->file_m->order_by('fi_created_at', 'DESC')->get_all();

        $this->twig->display('back/content/media_v', $this->data_back);
    }

    public function inline_update_media() {
        // assignment of variables
        $value  = $this->input->post('value');
        $name   = $this->input->post('name');
        $pk     = $this->input->post('pk');

        // For proper rules check in '$this->form_validation->run()' method
        $_POST[$name] = $value;

        // Setting rules
        $this->form_validation->set_rules($this->file_m->rules['inline-update'][$name]);

        // Validation process
        if($this->form_validation->run()) {
            // Update the data
            $this->file_m->update(array(
                $name => $value,
                'fi_updated_by' => $this->data_back['us_id']
            ), $pk);
            echo json_encode(array('status' => 1, 'msg' => 'Zmieniono dane'));
        } else {
            $this->form_validation->set_error_delimiters('', '');
            echo json_encode(array('status' => 0, 'msg' => validation_errors()));
        }
    }

    public function delete_media($fi_id, $fi_name, $fi_extension) {
        if(!is_int($fi_id)) {
            $this->file_m->delete($fi_id);

            unlink('./uploads/' . $fi_name . $fi_extension);
            unlink('./uploads/' . $fi_name . '_thumb' . $fi_extension);

            $this->session->set_flashdata('success', 'Usunięto plik');
            redirect('back/content/media');
        } else {
            $this->session->set_flashdata('error', 'Coś poszło nie tak');
            redirect('back/content/media');
        }
    }
}