<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuration {
    private $_CI;
    private $_configuration = array();
    
    public function __construct() {
        $this->_CI =& get_instance();
        $this->_CI->load->database();
        $config = $this->_CI->db->get('config')->result();
        foreach ($config as $row) {
            $this->_configuration[$row->property] = $row->contents;
        }
    }
    public function get($path = NULL, $return_as_array = false) {
        if($path) {
            $config = $this->_configuration;
            $path = explode('/', $path);
            
            foreach($path as $bit) {
                if(isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }
            if(is_array($config)) {
                return ($return_as_array == true) ? $config : false;
            }
            else {
                return $config;
            }
        }
        else {
            return false;
        }
    }
}