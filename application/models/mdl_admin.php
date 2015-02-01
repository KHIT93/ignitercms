<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'models/mdl_content.php';

class Mdl_Admin extends Mdl_Content {
    public function __construct() {
        parent::__construct();
    }
    public function prepare($area = 'dashboard', $data = NULL) {
        if(is_object($data)) {
            $this->_data = $data;
        }
        $method = '_prepare_admin_'.$area;
        $this->_data->content = $this->$method();
        $this->_return['head_title'] = $this->_prepare_head_title();
        $this->_return['head'] = $this->_prepare_head()."\n";
        $this->_return['styles'] = $this->_prepare_head_styles();
        $this->_return['page_top'] = '';
        $this->_return['page'] = $this->_prepare_page($area);
        $this->_return['page_bottom'] = '';
        $this->_return['scripts'] = (isset($this->_theme_data['scripts'])) ? $this->_prepare_scripts(): '';
        return $this->_return;
    }
    protected function _prepare_page($area) {
        $sections = array();
        foreach ($this->_theme_data['sections'] as $section => $name) {
            if($section == 'sidebar_first') {
                $sections[$section] = $this->_prepare_menu_admin();
            }
            else if($section == 'content') {
                
                $sections[$section] = $this->load->view($this->theme->tpl_path('node', $this->configuration->get('admin_theme')).'/node.tpl.php', $this->_data, true);
            }
            else {
                $sections[$section] = $this->_prepare_page_section($section);
            }
        }
        return $this->load->view($this->theme->tpl_path('page', $this->configuration->get('admin_theme')).'/page.tpl.php', array('page' => $sections, 'site_name' => $this->configuration->get('site_name'), 'breadcrumb' => breadcrumb($this->uri->segments)), true);
    }
    protected function _prepare_head_title() {
        return ((isset($this->_data->head_title) && !is_null($this->_data->head_title)) ? $this->_data->head_title : $this->_data->title).' - '.$this->configuration->get('site_name');
    }
    private function _prepare_menu_admin() {
        $menu = array();
        $menu[] = array(
            'title' => '<i class="menu-icon fa fa-tachometer"></i><span>'.t('Dashboard').'</span>',
            'link' => base_url().'admin/dashboard'
        );
        $menu[] = array(
            'title' => '<i class="menu-icon fa fa-pencil-square-o"></i><span>'.t('Content').'</span>',
            'link' => base_url().'admin/content'
        );
        $menu[] = array(
            'title' => '<i class="menu-icon fa fa-desktop"></i><span>'.t('Layout').'</span>',
            'link' => base_url().'admin/layout',
            'children' => array(
                array(
                    'title' => t('Content types'),
                    'link' => base_url().'admin/layout/content-types'
                ),
                array(
                    'title' => t('Menus'),
                    'link' => base_url().'admin/layout/menus'
                ),
                array(
                    'title' => t('Themes'),
                    'link' => base_url().'admin/layout/themes'
                ),
                array(
                    'title' => t('Widgets'),
                    'link' => base_url().'admin/layout/widgets'
                ),
            )
        );
        $menu[] = array(
            'title' => '<i class="menu-icon fa fa-puzzle-piece"></i><span>'.t('Modules').'</span>',
            'link' => base_url().'admin/modules'
        );
        $menu[] = array(
            'title' => '<i class="menu-icon fa fa-users"></i><span>'.t('Users').'</span>',
            'link' => base_url().'admin/users'
        );
        $menu[] = array(
            'title' => '<i class="menu-icon fa fa-gears"></i><span>'.t('Settings').'</span>',
            'link' => base_url().'admin/settings'
        );
        $menu[] = array(
            'title' => '<i class="menu-icon fa fa-signal"></i><span>'.t('Reports').'</span>',
            'link' => base_url().'admin/reports'
        );
        return sidebar_traverse($menu, 'nav nav-list', true);
    }
    private function _prepare_admin_dashboard() {
        
    }
    private function _prepare_admin_content() {
        $data = $this->db->get('pages')->result();
        $output = anchor(base_url().'content/add', '<i class="ace-icon fa fa-plus"></i>'.t('Add content'), 'class="btn btn-sm btn-info"')
                . '<div class="hr hr-18 dotted"></div>'
                . '<div class="row">'."\n";
        $output .= '<div class="col-xs-12">'."\n";
        $output .= '<table class="table table-striped table-bordered table-hover">'
                . '<thead>'
                . '<tr>'
                . '<th>'.t('Title').'</th>'
                . '<th>'.t('Author').'</th>'
                . '<th>'.t('Status').'</th>'
                . '<th><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>'.t('Last modified').'</th>'
                . '<th></th>'
                . '</tr>'
                . '</thead>';
        $output .= '<tbody>';
        foreach ($data as $node) {
            $output .= '<tr>'
                    . '<td>'
                    . anchor(base_url().'content/'.$node->pid, $node->title)
                    . '</td>'
                    . '<td>'
                    . $node->author
                    . '</td>'
                    . '<td>'
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
    private function _prepare_admin_content_add() {
        $form = $this->load->library('form', $this->appforms->getForm('content_add'))->render();
        $this->wysiwyg->init();
        return $form;
    }
    private function _prepare_admin_content_edit() {
        $_POST = $this->db->select('*')->from('pages')->where('pid', $this->uri->segment(2))->get()->result_array()[0];
        $form = $this->load->library('form', $this->appforms->getForm('content_edit'))->render();
        $this->wysiwyg->init();
        return $form;
    }
    private function _prepare_admin_content_delete() {
        $form = '<p>'.t('Are you sure that you want to delete <i>%page</i>?', array('%page' => $this->db->select('title')->from('pages')->where('pid', $this->uri->segment(2))->get()->result()[0]->title)).'</p>'."\n";
        $form .= $this->load->library('form', $this->appforms->getForm('content_delete'))->render();
        
        return $form;
    }
    private function _prepare_admin_layout() {
        $output = t('Please choose an action below').'<hr>';
        $output .= '<div class="list-group">';
        $menu = array(
            array(
                'title' => t('Content types'),
                'description' => t('Manage different types of content for use on the website'),
                'link' => 'content-types'
            ),
            array(
                'title' => t('Menus'),
                'description' => t('Manage menus and their links'),
                'link' => 'menus'
            ),
            array(
                'title' => t('Themes'),
                'description' => t('Change the appearance of your website by choosing a theme'),
                'link' => 'themes'
            ),
            array(
                'title' => t('Widgets'),
                'description' => t('Give life to your site by adding widgets to different sections of the page'),
                'link' => 'widgets'
            )
        );
        foreach($menu as $item) {
            $output .= anchor(base_url().'admin/layout/'.$item['link'], heading($item['title'], 4, 'class="list-group-item-heading"').'<p>'.$item['description'].'</p>', array('class' => 'list-group-item'));
        }
        $output .= '</div>';
        return $output;
    }
    private function _prepare_admin_layout_content_types() {
        
    }
    private function _prpare_admin_layout_menus() {
        
    }
    private function _prepare_admin_layout_themes() {
        
    }
    private function _prepare_admin_layout_widgets() {
        
    }
    private function _prepare_admin_modules() {
        
    }
    private function _prepare_admin_users() {
        
    }
    private function _prepare_admin_settings() {
        
    }
    private function _prepare_admim_reports() {
        
    }
}