<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'models/mdl_admin.php';

class Mdl_Admin_Users extends Mdl_Admin {
    public function __construct() {
        parent::__construct();
    }
    
    protected function _prepare_admin_users() {
        $data = $this->db->get('users')->result();
        $output = $this->_user_tabs();
        $output .= anchor(base_url().'user/add', '<i class="ace-icon fa fa-plus"></i>'.t('Add user'), 'class="btn btn-sm btn-info"')
                . '<div class="hr hr-18 dotted"></div>';
        $output .= '<table class="table table-striped table-bordered table-hover">'
                . '<thead>'
                . '<tr>'
                . '<th class="hidden-xs">'.t('Name').'</th>'
                . '<th>'.t('Username').'</th>'
                . '<th class="hidden-xs">'.t('Role').'</th>'
                . '<th>'.t('Actions').'</th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>';
        foreach ($data as $user) {
            $output .= '<tr>'
                    . '<td class="hidden-xs">'.$user->name.'</td>'
                    . '<td>'.anchor(base_url().'user/'.$user->uid.'/edit', $user->username).'</td>'
                    . '<td class="hidden-xs">'.$user->role.'</td>'
                    . '<td style="text-align:right;">'
                    . anchor(base_url().'user/'.$user->uid.'/edit', t('Edit'), 'class="btn btn-xs btn-default"').' '
                    . (($user->active == 1) ? anchor(base_url().'user/'.$user->uid.'/disable', t('Disable'), 'class="btn btn-xs btn-info"') : anchor(base_url().'user/'.$user->uid.'/enable', t('Enable'), 'class="btn btn-xs btn-info"')).' '
                    . anchor(base_url().'user/'.$user->uid.'/delete', t('Delete'), 'class="btn btn-xs btn-danger"').' '
                    . '</td>'
                    . '</tr>';
        }
        $output .= '</tbody>'
                . '</table>';
        $output .= $this->_user_tabs_close();
        return $output;
    }
    protected function _prepare_admin_users_add() {
        $form = $this->load->library('form', $this->appforms->getForm('users_add'))->render();
        return $form;
    }
    protected function _prepare_admin_users_roles() {
        $data = $this->db->get('roles')->result();
        $output = $this->_user_tabs();
        $output .= validation_errors();
        $output .= form_open('', array('name' => 'users_roles_add'));
        $output .= '<table class="table table-striped table-bordered table-hover">'
                . '<thead>'
                . '<tr>'
                . '<th>'.t('Name').'</th>'
                . '<th>'.t('Actions').'</th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>';
        foreach ($data as $role) {
            $output .= '<tr>'
                    . '<td>'.$role->name.'</td>'
                    . '<td style="text-align:right;">'
                    . anchor(base_url().'user/roles/'.$role->rid.'/edit', t('Edit'), 'class="btn btn-xs btn-default"').' '
                    . anchor(base_url().'user/roles/'.$role->rid.'/delete', t('Delete'), 'class="btn btn-xs btn-danger"').' '
                    . '</td>'
                    . '</tr>';
        }
        $output .= '<tr>'
                . '<td>'.form_input(array('name' => 'name', 'placeholder' => t('Role name'), 'class' => 'form-control')).'</td>'
                . '<td style="text-align:right;">'.form_button(array('type' => 'submit', 'name' => 'users_roles_add_submit', 'content' => t('Add role'), 'class' => 'btn btn-sm btn-primary')).'</td>'
                . '</tr>';
        $output .= '</tbody>'
                . '</table>';
        $output .= form_close();
        $output .= $this->_user_tabs_close();
        return $output;
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
        $output = $this->_user_tabs();
        $output .= validation_errors();
        $output .= form_open('', array('name' => 'users_permissions'));
        $output .= '<table class="table table-striped table-bordered table-hover">'
                . '<thead>'
                . '<tr>'
                . '<th>'.t('Permission').'</th>';
        foreach ($roles as $role) {
            $output .= '<th><strong>'.ucfirst(t($role->name)).'</strong></th>';
        }
        $output .= '</tr>'
                . '</thead>'
                . '<tbody>';;
        foreach ($data as $permission) {
            $output .= '<tr>'
                    . '<td>'.$permission->name.'<br/>'
                    . '<small>'.$permission->description.'</small>'
                    . '</td>';
            foreach ($roles as $role) {
                $output .= '<td style="text-align:center;">'.form_checkbox(array('name' => $permission->permission.'[]', 'value' => $role->rid, 'checked' => ((in_array($role->rid, explode(';', $permission->rid))) ? true : false))).'</td>';
            }
            $output .= '</tr>';
        }
        $output .= '</tbody>'
                . '</table>';
        $output .= form_button(array('type' => 'submit', 'name' => 'users_permissions_edit_submit', 'content' => t('Save changes'), 'class' => 'btn btn-sm btn-primary'));
        $output .= form_close();
        $output .= $this->_user_tabs_close();
        return $output;
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
    private function _user_tabs() {
        $output = '<div class="tabbable">'
                . '<ul class="nav nav-tabs tab-color-blue">'
                . '<li'.(($this->uri->uri_string == 'admin/users') ? ' class="active"' : '').'>'.anchor(base_url().'admin/users', t('Users')).'</li>'
                . '<li'.(($this->uri->uri_string == 'admin/users/roles') ? ' class="active"' : '').'>'.anchor(base_url().'admin/users/roles', t('Roles')).'</li>'
                . '<li'.(($this->uri->uri_string == 'admin/users/permissions') ? ' class="active"' : '').'>'.anchor(base_url().'admin/users/permissions', t('Permissions')).'</li>'
                . '</ul><br/>';
        return $output;
    }
    private function _user_tabs_close() {
        $output = '</div>';
        return $output;
    }
}