<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'models/mdl_admin.php';

class Mdl_Admin_Content extends Mdl_Admin {
    public function __construct() {
        parent::__construct();
    }
    
    protected function _prepare_admin_content() {
        $data = $this->db->get('pages')->result();
        $output = anchor(base_url().'content/add', '<i class="ace-icon fa fa-plus"></i>'.t('Add content'), 'class="btn btn-sm btn-info"')
                . '<div class="hr hr-18 dotted"></div>'
                . '<div class="row">'."\n";
        $output .= '<div class="col-xs-12">'."\n";
        $output .= '<table class="table table-striped table-bordered table-hover">'
                . '<thead>'
                . '<tr>'
                . '<th>'.t('Title').'</th>'
                . '<th class="hidden-xs">'.t('Author').'</th>'
                . '<th class="hidden-xs">'.t('Status').'</th>'
                . '<th><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>'.t('Last modified').'</th>'
                . '<th>'.t('Actions').'</th>'
                . '</tr>'
                . '</thead>';
        $output .= '<tbody>';
        foreach ($data as $node) {
            $output .= '<tr>'
                    . '<td>'
                    . anchor(base_url().'content/'.$node->pid, $node->title)
                    . '</td>'
                    . '<td class="hidden-xs">'
                    . $node->author
                    . '</td>'
                    . '<td class="hidden-xs">'
                    . $node->status
                    . '</td>'
                    . '<td>'
                    . $node->last_updated
                    . '</td>'
                    . '<td>'
                    . '<div class="hidden-sm hidden-xs">'
                    . anchor(base_url().'content/'.$node->pid.'/edit', '<i class="ace-icon fa fa-pencil"></i>'.t('Edit'), 'class="btn btn-xs btn-primary"')
                    .' '
                    . anchor(base_url().'content/'.$node->pid.'/delete', '<i class="ace-icon fa fa-trash-o"></i>'.t('Delete'), 'class="btn btn-xs btn-danger"')
                    . '</div>'
                    . '</td>'
                    . '</tr>';
        }
        $output .= '</tbody>';
        $output .= '</table>';
        $output .= '</div>'."\n";
        $output .= '</div>'."\n";
        return $output;
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