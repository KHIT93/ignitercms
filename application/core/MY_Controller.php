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
}