<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'models/mdl_admin.php';

class Mdl_Admin_Users extends Mdl_Admin {
    public function __construct() {
        parent::__construct();
    }
    
    protected function _prepare_admin_users() {
        $data = $this->db->get('users')->result();
        $output = $this->load->view('view_admin_users', array('data' => $data), TRUE);
        return $this->load->view('view_admin_users_tab_container', array('content' => $output), TRUE);
    }
    protected function _prepare_admin_users_add() {
        $form = $this->load->library('form', $this->appforms->getForm('users_add'))->render();
        return $form;
    }
    protected function _prepare_admin_users_roles() {
        $data = $this->db->get('roles')->result();
        $output = $this->load->view('view_admin_users_roles', array('data' => $data), TRUE);
        return $this->load->view('view_admin_users_tab_container', array('content' => $output), TRUE);
    }
    private function _prepare_admin_users_roles_submit() {
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules($this->appforms->getValidationRules('users_roles_add'));
        if($this->form_validation->run($this)) {
            $postdata = $this->input->post(NULL, TRUE);
            unset($postdata['users_roles_add_submit']);
            //Check permission and log the user in
            if($this->db->insert('roles', $postdata)) {
                set_message(t('The new user role <i>%role</i> has been created', array('%role' => $postdata['name'])), 'success');
            }
            else {
                set_message(t('The new user role could not be created. Please see the error log for details'), 'error');
            }
        }
    }
    protected function _prepare_admin_users_permissions() {
        if($_POST) {
            $this->_prepare_admin_users_permissions_submit();
        }
        $data = Modules::run('permission/_get_all');
        $roles = Modules::run('role/_get_all');
        $output = $this->load->view('view_admin_users_permissions', array('data' => $data, 'roles' => $roles), TRUE);
        return $this->load->view('view_admin_users_tab_container', array('content' => $output), TRUE);
    }
    protected function _prepare_admin_users_permissions_submit() {
        $data = $this->input->post(NULL, TRUE);
        $update_batch = array();
        foreach ($data as $permission => $roles) {
            $update_batch[] = array(
                'permission' => $permission,
                'rid' => ((is_array($roles) ? implode(';', $roles) : $roles))
            );
        }
        if($this->db->update_batch('permissions', $update_batch, 'permission')) {
            set_message(t('Permissions were successfully updated'), 'success');
        }
        else {
            set_message(t('Permissions could not be correctly updated. Please see the error log for details'), 'error');
        }
    }
}