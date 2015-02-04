<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->module('user');
    }
    
    public function add($data = NULL) {
        //Add new permission
    }
    
    public function edit($data = NULL) {
        //Edit existing permission
    }
    
    public function revoke($data = NULL) {
        //Remove permission
    }
    
    public function config() {
        //Demo function
    }
    
    public function check($permission = NULL) {
        //Check if a user has the chosen permission
        if($permission) {
            $rid = explode(';', $this->db->select('rid')->from('permissions')->where('permission', $permission)->get()[0]);
            return (in_array($this->user->rid(), $rid)) ? true : false;
        }
        else {
            return NULL;
        }
    }
    
}