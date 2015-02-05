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