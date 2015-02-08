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
            /*if($this->uri->segment(2) == 'login') {
                $this->load->model('mdl_admin_login', 'node');
            }
            else {
                if($this->user->is_logged_in()) {
                    $this->load->model('mdl_admin', 'node');
                }
                else {
                    $this->load->model('mdl_admin_login', 'node');
                }
            }*/
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
            $this->load->model('mdl_admin_login', 'node');
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
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            $this->load->model('mdl_admin', 'node');
            $data = new stdClass();
            $data->head_title = t('Administration');
            $data->title = t('Dashboard');
            $data = $this->node->prepare('dashboard', $data);
            $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
        }
        public function content() {
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            $this->load->model('mdl_admin_content', 'node');
            $data = new stdClass();
            $data->head_title = t('Content Management');
            $data->title = t('Content');
            $data = $this->node->prepare('content', $data);
            $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
        }
        public function layout($area = NULL) {
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            $this->load->model('mdl_admin_layout', 'node');
            $data = new stdClass();
            if($area) {
                switch ($area) {
                    case 'content-types':
                        $data = $this->content_types();
                    break;
                    case 'menus':
                        $data = $this->menus();
                    break;
                    case 'themes':
                        $data = $this->themes();
                    break;
                    case 'widgets':
                        $data = $this->widgets();
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
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            $data->head_title = t('Administration');
            $data->title = t('Layout');
            $data = $this->node->prepare('layout', $data);
        }
        public function content_types() {
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            
        }
        public function menus() {
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            $data = new stdClass();
            $data->head_title = t('Menus');
            $data->title = t('Menus');
            $area = $this->uri->segment(4);
            $action = $this->uri->segment(5);
            if(isset($area) && !is_null($area)) {
                if($area == 'add') {
                    return $this->node->prepare('layout_menus_add', $data);
                }
                else {
                    switch ($action) {
                        case 'edit':
                            return $this->node->prepare('layout_menus_edit', $data);
                        break;
                        case 'delete':
                            return $this->node->prepare('layout_menus_delete', $data);
                        break;
                        case 'links':
                            return $this->_menu_links($data);
                        break;
                        default:
                            return $this->node->prepare('layout_menus', $data);
                        break;
                    }
                }
            }
            else {
                return $this->node->prepare('layout_menus', $data);
            }
        }
        private function _menu_links($data) {
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            $link_action = $this->uri->segment(6);
            if($link_action == 'add') {
                return $this->node->prepare('layout_menus_links_add', $data);
            }
            else {
                $link_action = $this->uri->segment(7);
                switch ($link_action) {
                    case 'edit':
                        return $this->node->prepare('layout_menus_links_edit', $data);
                    break;
                    case 'delete':
                        return $this->node->prepare('layout_menus_links_delete', $data);
                    break;
                    default:
                        return $this->node->prepare('layout_menus_links', $data);
                    break;
                }
            }
        }
        public function themes() {
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            $data = new stdClass();
            $data->head_title = t('Theme management');
            $data->title = t('Themes');
            return $this->node->prepare('layout_themes', $data);
            
        }
        public function widgets() {
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            $data = new stdClass();
            $data->title = t('Widgets');
            $area = $this->uri->segment(4);
            if(is_numeric($area)) {
                $action = $this->uri->segment(5);
                switch ($action) {
                    case 'edit':
                        return $this->node->prepare('layout_widgets_edit', $data);
                    break;
                    case 'edit':
                        return $this->node->prepare('layout_widgets_edit', $data);
                    break;
                    default:
                        return $this->node->prepare('layout_widgets', $data);
                    break;
                }
            }
            else if($area == 'add') {
                return $this->node->prepare('layout_widgets_add', $data);
            }
            else {
                return $this->node->prepare('layout_widgets', $data);
            }
        }
        public function modules() {
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            $this->load->model('mdl_admin_modules', 'node');
            $data = new stdClass();
            $data->title = t('Modules');
            $data = $this->node->prepare('modules', $data);
            $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
        }
        public function users($area = NULL) {
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            $this->load->model('mdl_admin_users', 'node');
            $data = new stdClass();
            if($area) {
                switch ($area) {
                    case 'roles':
                        $data = $this->_users_roles();
                    break;
                    case 'permissions':
                        $data = $this->_users_permissions();
                    break;
                    default:
                        show_404();
                        break;
                }
            }
            else {
                $data->head_title = t('User Management');
                $data->title = t('Users');
                $data = $this->node->prepare('users', $data);
            }
            $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
        }
        private function _users_roles() {
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            $data = new stdClass();
            $data->title = t('User roles');
            return $this->node->prepare('users_roles', $data);
        }
        private function _users_permissions() {
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            $data = new stdClass();
            $data->title = t('Permissions');
            return $this->node->prepare('users_permissions', $data);
        }
        public function settings() {
            $option = $this->uri->segment(3);
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            $this->load->model('mdl_admin_settings', 'node');
            $data = new stdClass();
            $data->title = t('Settings');
            $data = $this->node->prepare('settings'.(($option) ? '_'.$option : ''), $data);
            $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
        }
        public function reports($report = NULL) {
            if(!$this->user->is_logged_in()) {
                show_error(t('You are not autorized to view this page'), 403, t('Access Denied'));
            }
            $this->load->model('mdl_admin_reports', 'node');
            $data = new stdClass();
            $data->title = t('Reports');
            $data = $this->node->prepare('reports', $data);
            $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
        }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */