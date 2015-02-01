<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {
    private $_username;
    private $_uid;
    private $_rid;
    private $_email;
    private $_name;
    private $_language;
    private $_active;
    public function __construct() {
        parent::__construct();
        if($this->is_logged_in()) {
            if($this->exists($this->session->userdata('uid'))) {
                $this->_populate($this->_get($this->session->userdata('uid')));
                
                if($this->_active != 1) {
                    $this->logout(t('Sorry, but your account is not activated'));
                }
            }
            else {
                $this->_uid = 0;
                $this->session->set_userdata('uid', 0);
                $this->session->set_userdata('logged_in', FALSE);
            }
        }
    }
    private function _get($user) {
        if(is_numeric($user)) {
            return $this->db->select('username, role, email, name, language, active')
                    ->from('users')
                    ->where('uid', $user)
                    ->get()
                    ->result()[0];
        }
        else if(valid_email($user)) {
            return $this->db->select('uid, username, role, name, language, active')
                    ->from('users')
                    ->where('email', $user)
                    ->get()
                    ->result()[0];
        }
        else {
            return $this->db->select('uid, role, email, name, language, active')
                    ->from('users')
                    ->where('username', $user)
                    ->get()
                    ->result()[0];
        }
    }
    private function _populate($data) {
        $this->_uid = $this->session->userdata('uid');
        $this->_username = $data->username;
        $this->_rid = $data->role;
        $this->_email = $data->email;
        $this->_name = $data->name;
        $this->_language = $data->language;
        $this->_active = $data->active;
    }
    public function index() {
        //Check if the user is logged in
        if($this->is_logged_in()) {
            //if logged in show the user profile page
        }
        else {
            //if not logged in show the login form
            $this->login();
        }
    }
    public function login() {
        if($_POST) {
            //validate, submit and redirect
            $this->_login_submit();
        }
        $data = new stdClass();
        $data->head_title = 'Login';
        $data->title = 'Login to your account';
        $data->content = $this->load->view('login_form', '', true);
        $this->load->model('mdl_content', 'node');
        $data = $this->node->prepare($data);
        $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
    }
    private function _login_submit() {
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules($this->appforms->getValidationRules('user_login'));
        if($this->form_validation->run($this)) {
            //Check permission and log the user in
            $this->log_in(array('username' => $this->input->post('username'), 'password' => $this->input->post('password')), base_url());
        }
    }
    public function log_in($userdata = NULL, $redirect = NULL) {
        if($userdata) {
            $user_password = $this->db->select('password')->from('users')->where('username', $userdata['username'])->get()->result()[0]->password;
            $user = $this->db->select('uid')
                    ->from('users')
                    ->where('username', $userdata['username'])
                    ->count_all_results();
            if($user > 0 && verify_secure_password($userdata['password'], $user_password)) {
                $data = $this->db->select('uid')->from('users')->where('username', $userdata['username'])->get()->result()[0];
                $this->session->set_userdata(array(
                    'uid' => $data->uid,
                    'logged_in' => TRUE
                ));
                redirect($redirect);
            }
        }
        else {
            set_message(t('Uauthorized access to function'), 'warning');
            redirect(base_url(), 'location', 302);
        }
    }
    public function logout($message = NULL) {
        if($message) {
            //set message as error on logout
            set_message($message, 'error');
        }
        $this->session->sess_destroy();
        redirect(base_url());
    }
    public function register() {
        $data = new stdClass();
        $data->head_title = 'Registration';
        $data->title = 'Register a new user account';
        $data->content = $this->load->view('register_form', '', true);
        $this->load->model('mdl_content', 'node');
        $data = $this->node->prepare($data);
        $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
    }
    private function _register_submit() {
        
    }
    public function exists($user) {
        if(is_numeric($user)) {
            if($this->db->select('uid')->from('users')->where('uid', $user)->count_all_results() > 0) {
                return true;
            }
        }
        else if(valid_email($user)) {
            if($this->db->select('uid')->from('users')->where('email', $user)->count_all_results() > 0) {
                return true;
            }
        }
        else {
            if($this->db->select('uid')->from('users')->where('username', $user)->count_all_results() > 0) {
                return true;
            }
        }
        return false;
    }
    public function is_logged_in() {
        if($this->session->userdata('logged_in')) {
            return true;
        }
        else {
            return false;
        }
    }
}