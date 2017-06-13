<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends MY_Model {
    public function __construct() {
        $this->table = 'user';
        $this->primary_key = 'us_id';
        $this->protected = ['us_id'];

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
        ],
        'create' => [
            'us_fname' => [
                'field' => 'us_fname',
                'label' => 'Imię',
                'rules' => 'trim|required'
            ],
            'us_lname' => [
                'field' => 'us_lname',
                'label' => 'Nazwisko',
                'rules' => 'trim|required'
            ],
            'us_email' => [
                'field' => 'us_email',
                'label' => 'E-mail',
                'rules' => 'trim|required|valid_email|is_unique[user.us_email]'
            ],
            'us_pass' => [
                'field' => 'us_pass',
                'label' => 'Hasło',
                'rules' => 'trim|required'
            ],
            'pass_conf' => [
                'field' => 'pass_conf',
                'label' => 'Powtórz hasło',
                'rules' => 'trim|required|matches[us_pass]'
            ]
        ],
        'inline-update' => [
            'us_fname' => [
                'us_fname' => [
                    'field' => 'us_fname',
                    'label' => 'Imię',
                    'rules' => 'trim|required'
                ]
            ],
            'us_lname' => [
                'us_lname' => [
                    'field' => 'us_lname',
                    'label' => 'Nazwisko',
                    'rules' => 'trim|required'
                ]
            ],
            'us_email' => [
                'us_email' => [
                    'field' => 'us_email',
                    'label' => 'E-mail',
                    'rules' => 'trim|required|valid_email|is_unique[user.us_email]'
                ]
            ],
            'us_pass' => [
                'us_pass' => [
                    'field' => 'us_pass',
                    'label' => 'Hasło',
                    'rules' => 'trim|required'
                ]
            ],
            'us_status' => [
                'us_status' => [
                    'field' => 'us_status',
                    'label' => 'Status',
                    'rules' => 'trim|required'
                ]
            ],
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

        $user = $this->user_m->where($conditions)->get();

        // Testing if there where found a user and setting session for the user
        if(!empty($user)) {
            // Check if the user has a active status and if NOT return FALSE
            if($user->us_status == 'Nieaktywny') {
                return FALSE;
            } else {
                // Preparing session data
                $data = [
                    'us_id'         => $user->us_id,
                    'us_fname'      => $user->us_fname,
                    'us_lname'      => $user->us_lname,
                    'us_email'      => $user->us_email,
                    'us_auth'       => $user->us_auth,
                    'loggedin'      => TRUE,
                    'us_pass_temp'  => FALSE
                ];

                // Checking if there is a temporary password set
                $user->us_pass != $user->us_pass_temp || $data['us_pass_temp'] = TRUE;

                // Session set
                $this->session->set_userdata($data);
            }
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

    /**
     * Reset method to set a new password and copy it in the temporary password field 'us_pass_temp'
     * Sending via e-mail a new password
     */
    public function reset() {
        $conditions = [
            'us_email' => $this->input->post('us_email')
        ];

        $email = $this->user_m->where($conditions)->get();

        if(!empty($email)) {
            $temp_pass = time();
            $temp_pass_hash = $this->hash_salt($temp_pass);
            $this->user_m->update(array('us_pass' => $temp_pass_hash, 'us_pass_temp' => $temp_pass_hash), $email->us_id);
            /*
            $this->load->library('email');

            $this->email->from('noreply@technet.systems', 'System');
            $this->email->to($email->us_email);

            $this->email->subject('Reset hasła');
            $this->email->message('Twoje tymczasowe hasło to: ' . $temp_pass . ' - użyj go do zalogowania do panelu administratora.');

            $this->email->send();
            */
        }
    }

    public function get_all_users() {
        // Checking if the user logged in is a super admin or not
        if($this->session->userdata('us_auth') == 'Super Admin') {
            // Fetch all userrs
            return $this->user_m->get_all();
        } else {
            // Fetch only the userr himself
            return $this->user_m->where('us_id', $this->session->userdata('us_id'))->get_all();
        }
    }
}