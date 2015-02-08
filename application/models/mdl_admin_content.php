<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'models/mdl_admin.php';

class Mdl_Admin_Content extends Mdl_Admin {
    public function __construct() {
        parent::__construct();
    }
    
    protected function _prepare_admin_content() {
        $output['data'] = $this->db->get('pages')->result();
        
        return $this->load->view('view_admin_content', $output, TRUE);
    }
    protected function _prepare_admin_content_add() {
        $form = $this->load->library('form', $this->appforms->getForm('content_add'))->render();
        $this->wysiwyg->init();
        return $form;
    }
    protected function _prepare_admin_content_edit() {
        $_POST = $this->db->select('*')->from('pages')->where('pid', $this->uri->segment(2))->get()->result_array()[0];
        $form = $this->load->library('form', $this->appforms->getForm('content_edit'))->render();
        $this->wysiwyg->init();
        return $form;
    }
    protected function _prepare_admin_content_delete() {
        $form = '<p>'.t('Are you sure that you want to delete <i>%page</i>?', array('%page' => $this->db->select('title')->from('pages')->where('pid', $this->uri->segment(2))->get()->result()[0]->title)).'</p>'."\n";
        $form .= $this->load->library('form', $this->appforms->getForm('content_delete'))->render();
        
        return $form;
    }
}