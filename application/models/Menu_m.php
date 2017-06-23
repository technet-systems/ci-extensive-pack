<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_m extends MY_Model {
    public function __construct() {
        $this->table = 'menu';
        $this->primary_key = 'me_id';
        $this->protected = ['me_id'];

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
            'nav-site' => [
                'me_pa_slug' => [
                    'field' => 'me_pa_slug',
                    'label' => 'Odnośnik',
                    'rules' => 'trim|required'
                ]
            ],
            'nav-anchor' => [
                'me_link' => [
                    'field' => 'me_link',
                    'label' => 'Adres odnośnika',
                    'rules' => 'trim|required'
                ],
                'me_title' => [
                    'field' => 'me_title',
                    'label' => 'Nazwa odnośnika',
                    'rules' => 'trim|required'
                ]
            ]
        ],
        'update' => [
            'me_title_alt' => [
                'field' => 'me_title_alt',
                'label' => 'Etykieta nawigacji',
                'rules' => 'trim|required'
            ]
        ]
    ];

    public function count_menu_items () {
        $menu_items = $this->menu_m->count_rows();
        return $menu_items + 1;
    }
}