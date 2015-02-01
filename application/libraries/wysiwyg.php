<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wysiwyg {
    private $_CI;
    private $_editor;
    public function __construct() {
        $this->_CI =& get_instance();
        $this->_CI->load->database();
        $this->_editor = $this->_CI->configuration->get('wysiwyg');
    }
    
    public function implement(&$scripts) {
        //Implements the Wysiwyg library and adds CSS and JS for the current Wysiwyg editor
        foreach ($this->_load_assets() as $script) {
            $scripts .= '<script src="'.base_url().$script.'"></script>'."\n";
        }
    }
    public function init() {
        $this->_CI->config->config['load_wysiwyg'] = TRUE;
    }
    private function _load_assets() {
        switch ($this->_editor) {
            case 'ckeditor':
                return array(
                    'frontend/core/wysiwyg/ckeditor/ckeditor.js',
                    'frontend/core/wysiwyg/ckeditor.config.js'
                );
            break;
            case 'ckeditor':
                return array(
                    'frontend/core/wysiwyg/tinymce/tinymce.min.js',
                    'frontend/core/wysiwyg/tinymce.config.js'
                );
            break;
            default:
                return NULL;
                break;
        }
    }
}