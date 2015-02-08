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
    public function index($uid = NULL) {
        if($this->uri->segment(1) == 'user' && is_numeric($this->uri->segment(2)) && !is_null($this->uri->segment(3))) {
            switch ($this->uri->segment(3)) {
                case 'edit':
                    $this->edit($pid);
                break;
                case 'delete':
                    $this->delete($pid);
                break;
                case 'enable':
                    $this->enable($pid);
                break;
                case 'disable':
                    $this->disable($pid);
                break;
                default:
                    break;
            }
        }
        else {
            //Check if the user is logged in
            if($this->is_logged_in()) {
                //if logged in show the user profile page
                $this->profile();
            }
            else {
                //if not logged in show the login form
                $this->login();
            }
        }
    }
    public function profile() {
        $data = new stdClass();
        $data->head_title = t('User profile');
        $data->title = $this->_name;
        $data->content = $this->load->view('user', '', true);
        $this->load->model('mdl_content', 'node');
        $data = $this->node->prepare($data);
        $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
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
    public function does_not_exist() {
        if($this->user->exists($this->input->post('username'))) {
            $this->form_validation->set_message('user_exists', t('The %s does already exist'));
            return false;
        }
        else {
            return true;
        }
    }
    public function is_logged_in() {
        if($this->session->userdata('logged_in')) {
            return true;
        }
        else {
            return false;
        }
    }
    public function add() {
        if($this->user->is_logged_in()) {
            if($_POST) {
                $this->_add_submit();
            }
            $this->config->config['force_admin_theme'] = TRUE;
            //Renders the add user form
            $this->load->model('mdl_admin_users', 'node');
            $data = new stdClass();
            $data->head_title = t('User Management');
            $data->title = t('Add user');
            $data = $this->node->prepare('users_add', $data);
            $this->load->view($this->theme->tpl_path('base', $this->configuration->get('admin_theme')).'/base.tpl.php', $data);
        }
        else {
            show_error(t('You are not authorized to view this page'), 403, t('Access Denied'));
        }
    }
    private function _add_submit() {
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules($this->appforms->getValidationRules('users_add'));
        if($this->form_validation->run($this)) {
            $postdata = $this->input->post(NULL, TRUE);
            unset($postdata['users_add_submit']);
            //Check permission and log the user in
            if($this->db->insert('users', $postdata)) {
                set_message(t('The new user <i>%user</i> has been created', array('%user' => $postdata['username'])), 'success');
            }
            else {
                set_message(t('The new user could not be created. Please see the error log for details'), 'error');
            }
        }
    }
    public function edit() {
        if($this->user->is_logged_in()) {
            if($_POST) {
                $this->_edit_submit();
            }
            $_POST = $this->db->get_where('users', array('uid' => $this->uri->segment(2)))->result_array()[0];
            $this->config->config['force_admin_theme'] = TRUE;
            //Renders the add user form
            $this->load->model('mdl_admin_users', 'node');
            $data = new stdClass();
            $data->head_title = t('User Management');
            $data->title = t('Edit user');
            $data = $this->node->prepare('users_add', $data);
            $this->load->view($this->theme->tpl_path('base', $this->configuration->get('admin_theme')).'/base.tpl.php', $data);
        }
        else {
            show_error(t('You are not authorized to view this page'), 403, t('Access Denied'));
        }
    }
    private function _edit_submit() {
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules($this->appforms->getValidationRules('users_edit'));
        if($this->form_validation->run($this)) {
            $postdata = $this->input->post(NULL, TRUE);
            unset($postdata['users_add_submit']);
            //Check permission and log the user in
            if($this->db->insert('users', $postdata)) {
                set_message(t('The user <i>%user</i> has been updated', array('%user' => $postdata['username'])), 'success');
            }
            else {
                set_message(t('The user could not be updated. Please see the error log for details'), 'error');
            }
        }
    }
    public function delete() {
        
    }
    public function enable() {
        
    }
    public function disable() {
        
    }
    public function _name() {
        return $this->_name;
    }
    public function _uid() {
        return $this->_uid;
    }
}