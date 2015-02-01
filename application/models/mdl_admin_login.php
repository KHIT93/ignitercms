<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'models/mdl_content.php';

class Mdl_Admin_Login extends Mdl_Content {
    public function __construct() {
        parent::__construct();
    }
    public function prepare() {
        $this->_data->head_title = t('Log in');
        $this->_data->content = $this->_prepare_login();
        $this->_return['head_title'] = $this->_prepare_head_title();
        $this->_return['head'] = $this->_prepare_head()."\n";
        $this->_return['styles'] = $this->_prepare_head_styles();
        $this->_return['scripts'] = (isset($this->_theme_data['scripts'])) ? $this->_prepare_scripts(): '';
        $temp_data = $this->_prepare_login();
        $this->_return['login_form'] = $temp_data['form'];
        $this->_return['go_home'] = $temp_data['go_home'];
        return $this->_return;
    }
    private function _prepare_login() {
        $data = array();
        
        /*$data['form'] = form_open()."\n\x20\x20\x20\x20";
        $data['form'] .= '<fieldset>'."\n\x20\x20\x20\x20"
                . '<label class="block clearfix">'
                . '<span class="block input-icon input-icon-right">'
                . form_input('username', '', 'class="form-control"')
                . '<i class="ace-icon fa fa-user"></i>'
                . '</span>'
                . '</label>'
                . '<label class="block clearfix">'
                . '<span class="block input-icon input-icon-right">'
                . form_password('password', '', 'class="form-control"')
                . '<i class="ace-icon fa fa-user"></i>'
                . '</span>'
                . '</label>'."\n\x20\x20\x20\x20"
                . '<div class="space"></div>'
                . '<div class="clearfix">'
                . '<label class="inline">'
                . form_checkbox('remember', 'true', FALSE, 'class="ace"')
                . '<span class="lbl"> Remember Me</span>'
                . '</label>'
                . form_submit('admin_login_submit', 'Login', 'class="width-35 pull-right btn btn-sm btn-primary"')
                . '</div>'
                . '<div class="space-4"></div>'
                . '</fieldset>'
                . form_close();*/
        $data['form'] = $this->load->library('form', $this->appforms->getForm('admin_login'))->render();
        $data['go_home'] = '<a href="'.base_url().'" class="forgot-password-link">'."\n\x20\x20\x20\x20"
                . '<i class="ace-icon fa fa-arrow-left"></i>'."\n\x20\x20\x20\x20"
                . t('Go to home page')."\n\x20\x20\x20\x20"
                . '</a>';
        
        return $data;
    }
}