<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller {
    public function __construct() {
        parent::__construct();
        //All modules that are installed and enabled should be autoloaded
        $modules = $this->db->get_where('modules', array('active' => 1))->result();
        foreach ($modules as $module) {
            $this->load->module($module->module);
        }
    }
    protected function _invoke($method = NULL) {
        if($method) {
            foreach ($this->db->select('module')->from('modules')->where('active', 1)->get()->result() as $module) {
                if(method_exists($this->{$module->module}, $method)) {
                    Modules::run($module->module.'/'.$method);
                }
            }
        }
    }
}