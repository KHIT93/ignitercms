<?php
if(!function_exists('user_roles_radio')) {
    function user_roles_list() {
        $CI =& get_instance();
        $data = array();
        foreach ($CI->db->get('roles')->result() as $role) {
            $data[$role->rid] = t($role->name);
        }
        return $data;
    }
}
if(!function_exists('set_user_role_id')) {
    function set_user_role_id() {
        $CI =& get_instance();
        $data = $CI->db->select('role')->from('users')->where('uid', $CI->uri->segment(2))->get()->result()[0]->role;
        return $data;
    }
}