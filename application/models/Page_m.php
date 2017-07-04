<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Page_m extends MY_Model {
    public function __construct() {
        $this->table = 'page';
        $this->primary_key = 'pa_id';
        $this->protected = ['pa_id'];

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

        $this->load->helper('text');
        $this->load->helper('file');
    }

    /**
     * Stores rules page create and inline-update
     *
     * @var array
     */
    public $rules = [
        'create' => [
            'pa_title' => [
                'field' => 'pa_title',
                'label' => 'Tytuł',
                'rules' => 'trim|required'
            ]
        ],
        'inline-update' => [
            'pa_title' => [
                'pa_title' => [
                    'field' => 'pa_title',
                    'label' => 'Tytuł',
                    'rules' => 'trim|required'
                ]
            ],
            'pa_title_alt' => [
                'pa_title_alt' => [
                    'field' => 'pa_title_alt',
                    'label' => 'Tytuł alternatywny',
                    'rules' => 'trim|required'
                ]
            ],
            'pa_slug' => [
                'pa_slug' => [
                    'field' => 'pa_slug',
                    'label' => 'Odnośnik',
                    'rules' => 'trim|required|is_unique[page.pa_slug]'
                ]
            ],
            'pa_order' => [
                'pa_order' => [
                    'field' => 'pa_order',
                    'label' => 'Kolejność',
                    'rules' => 'trim|is_natural|required'
                ]
            ],
            'pa_status' => [
                'pa_status' => [
                    'field' => 'pa_status',
                    'label' => 'Status',
                    'rules' => 'trim|required'
                ]
            ],
            'pa_description' => [
                'pa_description' => [
                    'field' => 'pa_description',
                    'label' => 'Opis',
                    'rules' => 'trim|required'
                ]
            ],
            'pa_layout' => [
                'pa_layout' => [
                    'field' => 'pa_layout',
                    'label' => 'Szablon',
                    'rules' => 'trim|required'
                ]
            ],
        ]
    ];

    public function create_slug($slug) {
        $slug = url_title(convert_accented_characters($slug), '-', TRUE);
        $slug_check = $this->page_m->where('pa_slug', $slug)->get();
        if($slug_check) {
            $slug = $slug . '-' . time();
            return $slug;
        } else {
            return $slug;
        }
    }

    public function get_all_pages() {
        return $this->page_m->get_all();
    }

    public function get_layouts() {
        return get_filenames(APPPATH.'views/build/layout/');
    }

    public function get_forms() {
        $modules = array();

        $files = get_filenames(APPPATH.'views/build/form/');
        foreach ($files as $file) {
            $modules[$file] = file_get_contents(APPPATH.'views/build/form/'.$file);
        }

        return $modules;
    }
}