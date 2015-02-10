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
        if(!method_exists($this, $method)) {
            show_404();
        }
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
        //To do
    }
}