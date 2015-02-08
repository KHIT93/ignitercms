<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'models/mdl_admin.php';

class Mdl_Admin_Modules extends Mdl_Admin {
    public function __construct() {
        parent::__construct();
    }
    
    protected function _prepare_admin_modules() {
        $mods = array();
        foreach (directory_map(APPPATH.'modules') as $mod) {
            $mods[] = str_replace('.info', '', $mod[0]);
        }
        foreach (directory_map('site/modules') as $mod) {
            $mods[] = str_replace('.info', '', $mod[0]);
        }
        
        return $this->load->view('view_admin_modules', array('mods' => $mods), TRUE);
    }
    protected function _prepare_admin_modules_add() {
        //To do
    }
    protected function _prepare_admin_modules_install() {
        
    }
    protected function _prepare_admin_modules_uninstall() {
        
    }
    protected function _prepare_admin_modules_config() {
        
    }
}