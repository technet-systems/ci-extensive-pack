<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_m extends MY_Model {
    public function __construct() {
        $this->table = 'user';
        $this->primary_key = 'us_id';
        $this->protected = ['us_id'];

        /*$this->has_one['user'] = array(
            'foreign_model'=>'V2auth_model',
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
     * Stores rules for login check
     *
     * @var array
     */
    public $rules = [
        'login' => [
            'us_email' => [
                'field' => 'us_email',
                'label' => 'E-mail',
                'rules' => 'trim|required|valid_email'
            ],
            'us_pass' => [
                'field' => 'us_pass',
                'label' => 'Hasło',
                'rules' => 'trim|required'
            ]
        ],
        'reset' => [
            'us_email' => [
                'field' => 'us_email',
                'label' => 'E-mail',
                'rules' => 'trim|required|valid_email'
            ]
        ]
    ];

    /**
     * Login method
     */
    public function login() {
        // Searching user by provided credentials
        $conditions = [
            'us_email'  => $this->input->post('us_email'),
            'us_pass'   => $this->hash_salt($this->input->post('us_pass'))
        ];

        $user = $this->auth_m->where($conditions)->get();

        // Testing if there where found a user and setting session for the user
        if(!empty($user)) {
            // Preparing session data
            $data = [
                'us_id'     => $user->us_id,
                'us_fname'  => $user->us_fname,
                'us_lname'  => $user->us_lname,
                'us_email'  => $user->us_email,
                'loggedin'  => TRUE
            ];

            // Session set
            $this->session->set_userdata($data);
        }
    }

    /**
     * Login check method
     *
     * @return bool
     */
    public function loggedin() {
        // Returns TRUE if the user's session is set and FALSE if not
        return (bool) $this->session->userdata('loggedin');
    }

    /**
     * The hash and salt method for passwords stored in the database
     *
     * @param $password
     * @return string
     */
    public function hash_salt($password) {
        return hash('sha512', $password . '--' . config_item('encryption_key'));

    }

    public function reset() {
        $conditions = [
            'us_email' => $this->input->post('us_email')
        ];

        $email = $this->auth_m->where($conditions)->get();

        if(!empty($email)) {
            $temp_pass = time();
            $temp_pass_hash = $this->hash_salt($temp_pass);
            $this->auth_m->update(array('us_pass' => $temp_pass_hash, 'us_pass_temp' => $temp_pass_hash), $email->us_id);
            /*
            $this->load->library('email');

            $this->email->from('noreply@technet.systems', 'System');
            $this->email->to($email->us_email);

            $this->email->subject('Reset hasła');
            $this->email->message('Twoje tymczasowe hasło to: ' . $temp_pass ' - użyj go do zalogowania do panelu administratora.');

            $this->email->send();
            */
        }
    }
}