<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function add($data = NULL) {
        //Add new role
    }
    
    public function edit($data = NULL) {
        //Edit existing role
    }
    
    public function delete($data = NULL) {
        //Remove role
    }
    
    public function _get_all() {
        return $this->db->get('roles')->result();
    }
    
}