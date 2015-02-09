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
        if(count($_POST)) {
            //upload and unpack the module
        }
        $this->_data->title = t('Add new module');
        $form = array(
            'name' => 'modules_add',
            '#permission' => 'access_admin_modules_add',
            '#multipart' => TRUE,
            '#elements' => array(
                array(
                    'type' => 'file',
                    'name' => 'module',
                    '#helpertext' => t('Valid formats are zip, tar.gz, tar.bz2')
                ),
                array(
                    'type' => 'markup',
                    'value' => '<hr>'
                ),
                array(
                    'type' => 'submit',
                    'name' => 'modules_add_submit',
                    'content' => t('Add module'),
                    'class' => 'btn btn-xs btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/modules',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-xs btn-default"',
                    'wrapper' => false
                )
            )
        );
        $data = array(
            'form' => $this->load->library('form', $form)->render(),
            'content' => t('Please browse your local computer for a module to upload')
        );
        return $this->load->view('view_admin_modules_add', $data, TRUE);
    }
    protected function _prepare_admin_modules_install() {
        if(count($_POST)) {
            Modules::run($this->_data->module.'/_install');
        }
        $this->_data->title = t('Install <i>%module</i> module?', array('%module' => $this->uri->segment(4)));
        $this->_data->head_title = t('Install module');
        $data = array(
            'module' => $this->uri->segment(4),
            'message' => t('Are you sure that you want to install the <i>%module</i> module?', array('%module' => $this->uri->segment(4))),
            'form_name' => 'modules_install',
            'action_text' => t('Install'),
            'btn_class' => 'btn btn-xs btn-primary'
        );
        return $this->load->view('view_admin_modules_install', $data, TRUE);
    }
    protected function _prepare_admin_modules_uninstall() {
        if(count($_POST)) {
            Modules::run($this->_data->module.'/_uninstall');
        }
        $this->_data->title = t('Uninstall <i>%module</i>', array('%module' => $this->uri->segment(4)));
        $this->_data->head_title = t('Uninstall module');
        $data = array(
            'module' => $this->uri->segment(4),
            'message' => t('Are you sure that you want to uninstall <i>%module</i>', array('%module' => $this->uri->segment(4))),
            'form_name' => 'modules_uninstall',
            'action_text' => t('Uninstall'),
            'btn_class' => 'btn btn-xs btn-danger'
        );
        return $this->load->view('view_admin_modules_install', $data, TRUE);
    }
    protected function _prepare_admin_modules_config() {
        if($this->_data->module == 'install') {
            return $this->_prepare_admin_modules_install();
        }
        else if($this->_data->module == 'uninstall') {
            return $this->_prepare_admin_modules_uninstall();
        }
        else if($this->_data->module == 'add') {
            return $this->_prepare_admin_modules_add();
        }
        else {
            if(is_dir(APPPATH.'modules/'.$this->_data->module) || is_dir('site/modules/'.$this->_data->module)) {
                if(count($_POST)) {
                    Modules::run ($this->_data->module.'/_config_submit');
                }
                return Modules::run($this->_data->module.'/_config');
            }
            else {
                show_404();
            }
        }
    }
}