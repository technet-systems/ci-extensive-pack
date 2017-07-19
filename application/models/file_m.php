<?php defined('BASEPATH') OR exit('No direct script access allowed');

class File_m extends MY_Model {
    public function __construct() {
        $this->table = 'file';
        $this->primary_key = 'fi_id';
        $this->protected = ['fi_id'];

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
        'inline-update' => [
            'fi_alt' => [
                'fi_alt' => [
                    'field' => 'fi_alt',
                    'label' => 'Tekst alternatywny',
                    'rules' => 'trim'
                ]
            ],
            'fi_description' => [
                'fi_description' => [
                    'field' => 'fi_description',
                    'label' => 'Opis',
                    'rules' => 'trim'
                ]
            ],
            'fi_label' => [
                'fi_label' => [
                    'field' => 'fi_label',
                    'label' => 'Etykieta wiodąca',
                    'rules' => 'trim'
                ]
            ],
            'fi_label_alt' => [
                'fi_label' => [
                    'field' => 'fi_label_alt',
                    'label' => 'Etykiety',
                    'rules' => 'trim'
                ]
            ]
        ]
    ];

}