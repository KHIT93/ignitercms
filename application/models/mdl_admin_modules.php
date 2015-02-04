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
        $output = anchor(base_url().'admin/layout/modules/add', '<i class="ace-icon fa fa-plus"></i>'.t('Add module').' (Disabled)', 'class="btn btn-sm btn-info disabled"')
                . '<div class="hr hr-18 dotted"></div>';
        $output .= '<table class="table table-striped table-bordered table-hover">'
                . '<thead>'
                . '<tr>'
                . '<th>'.t('Name').'</th>'
                . '<th class="hidden-xs">'.t('Description').'</th>'
                . '<th>'.t('Actions').'</th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>';
        foreach ($mods as $mod) {
            $data = (is_dir(APPPATH.'modules/'.$mod)) ? parse_info_file(APPPATH.'modules/'.$mod.'/'.$mod.'.info'): parse_info_file('site/modules/'.$mod.'/'.$mod.'.info');
            $output .= '<tr>'
                    . '<td>'.$data['name'].'</td>'
                    . '<td class="hidden-xs">'.$data['description'].'</td>'
                    . '<td style="text-align:right;">';
            $active = ($this->db->where('module', $mod)->count_all_results('modules') > 0) ? $this->db->select('active')->from('modules')->where('module', $mod)->get()->result()[0]->active : 0;
            if($active == 1) {
                if(method_exists($this->{$mod}, 'config')) {
                    if(isset($data['config'])) {
                        $output .= anchor(base_url().$data['config'], t('Configure'), 'class="btn btn-xs btn-primary"').' ';
                    }
                    else {
                        $output .= anchor(base_url().'admin/modules/'.$mod, t('Configure'), 'class="btn btn-xs btn-primary"').' ';
                    }
                }
                $output .= anchor(base_url().'admin/modules/uninstall/'.$mod, t('Uninstall'), 'class="btn btn-xs btn-danger"');
            }
            else {
                $output .= anchor(base_url().'admin/modules/install/'.$mod, t('Install'), 'class="btn btn-xs btn-success"');
            }
            $output .= '</td>'
                    . '</tr>';
        }
        $output .= '</tbody>'
                . '</table>';
        return $output;
    }
    protected function _prepare_admin_modules_add() {
        //To do
    }
    protected function _prepare_admin_modules_install() {
        
    }
    protected function _prepare_admin_modules_uninstall() {
        
    }
    protected function _prepare_admin_modules_config() {
        
    }
}