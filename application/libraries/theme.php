<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Theme {
    // hold CI instance
    private $_CI;
    
    public function __construct() {
        $this->_CI =& get_instance();
        $this->_CI->load->database();
    }
    public function current() {
        //returns the current theme from the database
        return ($this->_CI->uri->segment(1) == 'admin' || $this->_CI->config->config['force_admin_theme'] == TRUE) ? $this->_CI->configuration->get('admin_theme'): $this->_CI->configuration->get('site_theme');
    }
    public function path_to_theme() {
        if(is_dir('frontend/themes/'.$this->current()) && $this->current() != 'default') {
            //Theme is in core
            return 'frontend/themes/'.$this->current();
        }
        else if(is_dir('/site/themes/'.$this->current()) && $this->current() != 'default') {
            //Theme is from 3rd party
            return '/site/themes/'.$this->current();
        }
        else {
            return 'frontend/themes/default';
        }
    }
    public function tpl_path($tpl_name) {
        //returns path for correct tpl-file to use
        if(file_exists($this->path_to_theme().'/'.$tpl_name.'.tpl.php') && $this->current() != 'default') {
            //return theme foldername as tpl_path
            return $this->current().'/';
        }
        else if(file_exists($this->path_to_theme().'/templates/'.$tpl_name.'.tpl.php') && $this->current() != 'default') {
            //return theme foldername and templates subfolder as tpl path
            return $this->current().'/templates/';
        }
        else {
            //return default theme tpl path if requested file does not exist
            return 'default/';
        }
    }
}