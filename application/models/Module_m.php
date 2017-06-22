<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Module_m extends MY_Model {
    public function __construct() {
        $this->table = 'module';
        $this->primary_key = 'mo_id';
        $this->protected = ['mo_id'];

        /*$this->has_one['user'] = array(
            'foreign_model'=>'V2user_model',
            'foreign_table'=>'v2_users',
            'foreign_key'=>'us_id',
            'local_key'=>'cl_us_id'
            );
        $this->has_many_pivot['insurances'] = [
            'foreign_model' => 'V2insurance_model',
            'pivot_table' => 'v2_clients_insurances',
            'local_key' => 'cl_id',
            'pivot_local_key' => 'ci_cl_id',
            'pivot_foreign_key' => 'ci_in_id',
            'foreign_key' => 'in_id'
        ];
        */

        parent::__construct();
    }

    /**
     * Stores rules for module forms
     *
     * @var array
     */
    public $rules = [
        'create' => [
            'CTA.twig' => [
                'var-main-text' => [
                    'field' => 'var-main-text',
                    'label' => 'Tekst główny',
                    'rules' => 'trim|required'
                ],
                'var-helper-text' => [
                    'field' => 'var-helper-text',
                    'label' => 'Tekst pomocniczy',
                    'rules' => 'trim'
                ],
                'var-button-text' => [
                    'field' => 'var-button-text',
                    'label' => 'Nazwa przycisku',
                    'rules' => 'trim|required'
                ],
                'var-uri' => [
                    'field' => 'var-uri',
                    'label' => 'Odnośnik',
                    'rules' => 'trim|required'
                ],
                'mo_layout' => [
                    'field' => 'mo_layout',
                    'label' => 'Formularz modułu',
                    'rules' => 'trim|required'
                ],
                'mo_description' => [
                    'field' => 'mo_description',
                    'label' => 'Opis modułu',
                    'rules' => 'trim'
                ]
            ]
        ],
        'update' => [
            'CTA.twig' => [
                'var-main-text' => [
                    'field' => 'var-main-text',
                    'label' => 'Tekst główny',
                    'rules' => 'trim|required'
                ],
                'var-helper-text' => [
                    'field' => 'var-helper-text',
                    'label' => 'Tekst pomocniczy',
                    'rules' => 'trim'
                ],
                'var-button-text' => [
                    'field' => 'var-button-text',
                    'label' => 'Nazwa przycisku',
                    'rules' => 'trim|required'
                ],
                'var-uri' => [
                    'field' => 'var-uri',
                    'label' => 'Odnośnik',
                    'rules' => 'trim|required'
                ],
                'mo_layout' => [
                    'field' => 'mo_layout',
                    'label' => 'Formularz modułu',
                    'rules' => 'trim|required'
                ],
                'mo_description' => [
                    'field' => 'mo_description',
                    'label' => 'Opis modułu',
                    'rules' => 'trim'
                ]
            ]
        ]
    ];

    public function parse_form_to_html ($mo_variables, $mo_layout) {
        $module_body = file_get_contents(APPPATH . 'views/build/module/' . $mo_layout);
        $mo_variables = json_decode($mo_variables);

        foreach ($mo_variables as $key => $value) {
            $module_body = str_replace('{{ ' . $key . ' }}', $value, $module_body);
        }

        return $module_body;
    }

    public function count_modules ($mo_layout, $mo_pa_id) {
        $modules = $this->module_m->where(array('mo_layout' => $mo_layout, 'mo_pa_id' => $mo_pa_id))->get_all();
        return count($modules) + 1;
    }

    public function create_editable_form($mo_variables, $mo_layout) {
        $module_form = file_get_contents(APPPATH . 'views/build/form/' . $mo_layout);
        $mo_variables = json_decode($mo_variables);

        // zamiana 'id' na 'value' w całym formularzu oraz dodanie wartości dla 'mo_description'
        $module_form = str_replace('id=', 'value=', $module_form);
        $module_form = str_replace('{{ mo_description }}', $_POST['mo_description'], $module_form);

        foreach ($mo_variables as $key => $value) {
            $module_form = str_replace('{{ ' . $key . ' }}', $value, $module_form);
        }

        return $module_form;
    }
}