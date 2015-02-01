<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
        public function __construct() {
            parent::__construct();
            //$this->load->library('admin');
            if($this->uri->segment(2) == 'login') {
                $this->load->model('mdl_admin_login', 'node');
            }
            else {
                if($this->user->is_logged_in()) {
                    $this->load->model('mdl_admin', 'node');
                }
                else {
                    $this->load->model('mdl_admin_login', 'node');
                }
            }
        }
        public function index()
	{   
            if($this->user->is_logged_in()) {
                $this->dashboard();
            }
            else {
                $this->login();
            }
	}
        public function login() {
            if($_POST) {
                //validate, submit and redirect
                $this->_login_submit();
            }
            $data = $this->node->prepare();
            $this->load->view($this->theme->tpl_path('admin_login').'/admin_login.tpl.php', $data);
        }
        private function _login_submit() {
            $this->load->library('form_validation');
            //Set validation rules
            $this->form_validation->set_rules($this->appforms->getValidationRules('admin_login'));
            if($this->form_validation->run($this)) {
                //Check permission and log the user in
                $this->user->log_in(array('username' => $this->input->post('username'), 'password' => $this->input->post('password')), 'admin/dashboard');
            }
            
        }
        private function generate() {
            if($_POST) {
                echo 'Your password is: '.secure_password($this->input->post('password', true));
            }
            $output = form_open();
            $output .= form_input('password');
            $output .= form_submit('generate_submit', 'Generate password');
            $output .= form_close();
            echo $output;
        }
        public function user_exists() {
            if($this->user->exists($this->input->post('username'))) {
                return true;
            }
            else {
                $this->form_validation->set_message('user_exists', t('The %s does not exist'));
                return false;
            }
        }
        public function dashboard() {
            $data = new stdClass();
            $data->head_title = t('Administration');
            $data->title = t('Dashboard');
            $data = $this->node->prepare('dashboard', $data);
            $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
        }
        public function content() {
            $data = new stdClass();
            $data->head_title = t('Content Management');
            $data->title = t('Content');
            $data = $this->node->prepare('content', $data);
            $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
        }
        public function layout($area = NULL) {
            $data = new stdClass();
            if($area) {
                switch ($area) {
                    case 'content-types':
                        $this->content_types();
                    break;
                    case 'menus':
                        $this->menus();
                    break;
                    case 'themes':
                        $this->themes();
                    break;
                    case 'widgets':
                        $this->layout_menu();
                    break;
                    default:
                        break;
                }
            }
            else {
                $data->head_title = t('Administration');
                $data->title = t('Layout');
                $data = $this->node->prepare('layout', $data);
            }
            $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
        }
        public function layout_menu() {
            $data->head_title = t('Administration');
            $data->title = t('Layout');
            $data = $this->node->prepare('layout', $data);
        }
        public function content_types() {
            
        }
        public function menus() {
            
        }
        public function themes() {
            
        }
        public function widgets() {
            
        }
        public function modules() {
            $data = new stdClass();
            $data->title = t('Modules');
            $data = $this->node->prepare('modules', $data);
            $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
        }
        public function users() {
            $data = new stdClass();
            $data->head_title = t('User Management');
            $data->title = t('Users');
            $data = $this->node->prepare('users', $data);
            $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
        }
        public function settings() {
            $data = new stdClass();
            $data->title = t('Settings');
            $data = $this->node->prepare('settings', $data);
            $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
        }
        public function reports($report = NULL) {
            $data = new stdClass();
            $data->title = t('Reports');
            $data = $this->node->prepare('reports', $data);
            $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
        }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */