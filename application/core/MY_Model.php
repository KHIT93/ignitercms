<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
    protected function _invoke($method = NULL, $params = NULL) {
        if($method) {
            foreach ($this->db->select('module')->from('modules')->where('active', 1)->get()->result() as $module) {
                if(method_exists($this->{$module->module}, $method)) {
                    Modules::run($module->module.'/'.$method, $params);
                }
            }
        }
    }
}