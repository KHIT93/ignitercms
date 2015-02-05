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
        $output .= $this->_user_tabs_close();
        $output .= '</tbody>'
                . '</table>';
        return $output;
    }
    protected function _prepare_admin_users_add() {
        $form = $this->load->library('form', $this->appforms->getForm('users_add'))->render();
        return $form;
    }
    protected function _prepare_admin_users_add_submit() {
        
    }
    protected function _prepare_admin_users_roles() {
        
    }
    protected function _prepare_admin_users_permissions() {
        
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