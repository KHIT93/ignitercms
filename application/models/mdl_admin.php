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
        //To do
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
        //To do
    }
    private function _prepare_admin_layout_menus() {
        $data = $this->db->get('menus')->result();
        $output = anchor(base_url().'admin/layout/menus/add', '<i class="ace-icon fa fa-plus"></i>'.t('Add menu'), 'class="btn btn-sm btn-info"')
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
        foreach ($data as $menu) {
            $output .= '<tr>'
                    . '<td>'.anchor(base_url().'admin/layout/menus/'.$menu->mid.'/links', $menu->name).'</td>'
                    . '<td class="hidden-xs">'.$menu->description.'</td>'
                    . '<td style="text-align:right;">'
                    . anchor(base_url().'admin/layout/menus/'.$menu->mid.'/edit', t('Edit'), 'class="btn btn-xs btn-default"').' '
                    . anchor(base_url().'admin/layout/menus/'.$menu->mid.'/links', t('View links'), 'class="btn btn-xs btn-info"').' '
                    . anchor(base_url().'admin/layout/menus/'.$menu->mid.'/delete', t('Delete'), 'class="btn btn-xs btn-danger"').' '
                    . '</td>'
                    . '</tr>';
        }
        $output .= '</tbody>'
                . '</table>';
        return $output;
    }
    private function _prepare_admin_layout_menus_add() {
        if($_POST) {
            $this->_prepare_admin_layout_menus_add_submit();
            redirect(base_url().'admin/layout/menus');
        }
        $form = $this->load->library('form', $this->appforms->getForm('menus_add'))->render();
        
        return $form;
    }
    private function _prepare_admin_layout_menus_add_submit() {
        $postdata['name'] = $this->input->post('name', TRUE);
        $postdata['description'] = $this->input->post('description', TRUE);
        if($this->db->insert('menus', $postdata)) {
            set_message(t('The new menu <i>%menu</i> has been created', array('%menu' => $postdata['name'])), 'success');
        }
        else {
            set_message(t('The new menu was not created. Please see the error log for details'), 'error');
        }
    }
    private function _prepare_admin_layout_menus_edit() {
        if($_POST) {
            $this->_prepare_admin_layout_menus_edit_submit();
            redirect(base_url().'admin/layout/menus');
        }
        $_POST = $this->db->select('*')->from('menus')->where('mid', $this->uri->segment(4))->get()->result_array()[0];
        $form = $this->load->library('form', $this->appforms->getForm('menus_edit'))->render();
        
        return $form;
    }
    private function _prepare_admin_layout_menus_edit_submit() {
        $postdata['name'] = $this->input->post('name', TRUE);
        $postdata['description'] = $this->input->post('description', TRUE);
        $mid = $this->input->post('mid', TRUE);
        $this->db->where('mid', $mid);
        if($this->db->update('menus', $postdata)) {
            set_message(t('The menu <i>%menu</i> has been updated', array('%menu' => $postdata['name'])), 'success');
        }
        else {
            set_message(t('The menu was not updated. Please see the error log for details'), 'error');
        }
    }
    private function _prepare_admin_layout_menus_links() {
        $data = $this->db->select('*')->from('menu_links')->where('mid', $this->uri->segment(4))->get()->result();
        $output = anchor(base_url().'admin/layout/menus/'.$this->uri->segment(4).'/links/add', '<i class="ace-icon fa fa-plus"></i>'.t('Add menu link'), 'class="btn btn-sm btn-info"')
                . '<div class="hr hr-18 dotted"></div>';
        $output .= '<table class="table table-striped table-bordered table-hover">'
                . '<thead>'
                . '<tr>'
                . '<th>'.t('Title').'</th>'
                . '<th>'.t('Actions').'</th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>';
        foreach ($data as $menu) {
            $output .= '<tr>'
                    . '<td>'.anchor(base_url().$menu->link, $menu->title).'</td>'
                    . '<td style="text-align:right;">'
                    . anchor(base_url().'admin/layout/menus/'.$menu->mid.'/links/'.$menu->mlid.'/edit', t('Edit'), 'class="btn btn-xs btn-default"').' '
                    . anchor(base_url().'admin/layout/menus/'.$menu->mid.'/links/'.$menu->mlid.'/delete', t('Delete'), 'class="btn btn-xs btn-danger"').' '
                    . '</td>'
                    . '</tr>';
        }
        $output .= '</tbody>'
                . '</table>';
        return $output;
    }
    private function _prepare_admin_layout_menus_links_add() {
        if($_POST) {
            $this->_prepare_admin_layout_menus_links_add_submit();
            redirect(base_url().'admin/layout/menus');
        }
        $form = $this->load->library('form', $this->appforms->getForm('menus_links_add'))->render();
        
        return $form;
    }
    private function _prepare_admin_layout_menus_links_add_submit() {
        $postdata = $this->input->post(NULL, TRUE);
        unset($postdata['menus_link_add_submit']);
        if($this->db->insert('menu_links', $postdata)) {
            set_message(t('The new menu item <i>%item</i> has been created', array('%item' => $postdata['title'])), 'success');
        }
        else {
            set_message(t('The new menu item could not be created. Please see the error log for details'), 'error');
        }
    }
    private function _prepare_admin_layout_menus_links_edit() {
        if($_POST) {
            $this->_prepare_admin_layout_menus_links_edit_submit();
            redirect(base_url().'admin/layout/menus');
        }
        $_POST = $this->db->select('*')->from('menu_links')->where('mlid', $this->uri->segment(6))->get()->result_array()[0];
        $form = $this->load->library('form', $this->appforms->getForm('menus_links_edit'))->render();
        
        return $form;
    }
    private function _prepare_admin_layout_menus_links_edit_submit() {
        $postdata = $this->input->post(NULL, TRUE);
        unset($postdata['menus_link_edit_submit']);
        $this->db->where('mlid', $this->uri->segment(6));
        if($this->db->update('menu_links', $postdata)) {
            set_message(t('The new menu item <i>%item</i> has been created', array('%item' => $postdata['title'])), 'success');
        }
        else {
            set_message(t('The new menu item could not be created. Please see the error log for details'), 'error');
        }
    }
    private function _prepare_admin_layout_menus_links_delete() {
        if($_POST) {
            $this->_prepare_admin_layout_menus_links_delete_submit();
            redirect(base_url().'admin/layout/menus');
        }
        $form = $this->load->library('form', $this->appforms->getForm('menus_links_edit'))->render();
        
        return $form;
    }
    private function _prepare_admin_layout_menus_links_delete_submit() {
        $this->db->where('mlid', $this->uri->segment(6));
        if($this->db->delete('menu_links')) {
            set_message(t('The new menu item <i>%item</i> has been created', array('%item' => $postdata['title'])), 'success');
        }
        else {
            set_message(t('The new menu item could not be created. Please see the error log for details'), 'error');
        }
    }
    private function _prepare_admin_layout_menus_delete() {
        if($_POST) {
            $this->_prepare_admin_layout_menus_delete_submit();
            redirect(base_url().'admin/layout/menus');
        }
        $form = $this->load->library('form', $this->appforms->getForm('menus_delete'))->render();
        
        return $form;
    }
    private function _prepare_admin_layout_menus_delete_submit() {
        $mid = $this->input->post('mid', TRUE);
        $this->db->where('mid', $mid);
        if($this->db->delete('menus', $postdata)) {
            set_message(t('The menu has been deleted'), 'success');
        }
        else {
            set_message(t('The menu was not deleted. Please see the error log for details'), 'error');
        }
    }
    private function _prepare_admin_layout_themes() {
        $segment = $this->uri->segment(5);
        if(isset($segment) && !is_null($segment)) {
            $this->db->where('property', 'site_theme');
            if($this->db->update('config', array('contents' => $this->uri->segment(4)))) {
                set_message(t('The theme <i>%theme</i> has been applied', array('%page' => $this->uri->segment(4))), 'success');
            }
            else {
                set_message(t('Something went wrong and the theme could not be applied. Please see the error log for details'), 'error');
            }
            //redirect(base_url().'admin/layout/themes');
        }
        $this->load->helper('directory');
        $data = array();
        foreach (directory_map('frontend/themes') as $folder => $content) {
            $data[$folder] = 'frontend/themes/'.$folder.'/'.$folder.'.info';
        }
        foreach (directory_map('site/themes') as $folder => $content) {
            if(isset($data[$folder])) {
                $data['site_'.$folder] = 'site/themes/'.$folder.'/'.$folder.'.info';
            }
            else {
                $data[$folder] = 'site/themes/'.$folder.'/'.$folder.'.info';
            }
        }
        $output = '<table class="table table-striped table-bordered table-hover">'
                . '<thead>'
                . '<tr>'
                . '<th></th>'
                . '<th></th>'
                . '</tr>'
                . '</thead>'
                . '<tobdy>';
        foreach ($data as $folder => $info_file) {
            $info_data = parse_info_file($info_file);
            $output .= '<tr>';
            $output .= '<td>'
                    . '<img src="'.$info_data['screenshot'].'">'
                    . '</td>'
                    . '<td>'
                    . heading($info_data['name'], 4)
                    . '<p>'.$info_data['description'].'</p>'
                    . '</td>'
                    . '</tr>';
            $output .= '<tr>'
                    . '<td colspan="2">'
                    . anchor(base_url().'admin/themes/'.$folder.'/apply', t('Apply theme'), 'class="btn btn-xs btn-default"')
                    . '</td>'
                    . '</tr>';
        }
        $output .= '</tbody>'
                . '</table>';
        return $output;
    }
    private function _prepare_admin_layout_widgets() {
        if($_POST) {
            $this->_prepare_admin_layout_widgets_submit();
        }
        $missing = array();
        $output = form_open('', array('name' => 'widget_position'));
        $output .= anchor(base_url().'admin/layout/widgets/add', '<i class="ace-icon fa fa-plus"></i>'.t('Add simple widget'), 'class="btn btn-sm btn-info"')
                . '<div class="hr hr-18 dotted"></div>';
        $output .= '<table class="table table-striped table-bordered table-hover">'
                . '<thead>'
                . '<tr>'
                . '<th>'.t('Name').'</th>'
                . '<th>'.t('Section').'</th>'
                . '<th>'.t('Actions').'</th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>';
        $sections = parse_info_file($this->theme->path_to_specifc_theme($this->configuration->get('site_theme')).'/'.$this->configuration->get('site_theme').'.info')['sections'];
        foreach ($sections as $section => $name) {
            $output .= '<tr>'
                    . '<td colspan="3"><i>'.$name.'</i></td>'
                    . '</tr>';
            $output .= $this->_prepare_admin_layout_widgets_section($section, $name, $missing);
        }
        
        $output .= '<tr>'
                . '<td colspan="3"><i>'.t('Inactive').'</i></td>'
                . '</tr>';
        if(count($missing) > 0) {
            foreach ($missing as $widget) {
                $output .= '<tr>'
                        . '<td style="padding-left: 2em;">'.$widget->title.'</td>'
                        . '<td>'.  form_dropdown('section', parse_info_file($this->theme->path_to_specifc_theme($this->configuration->get('site_theme')).'/'.$this->configuration->get('site_theme').'.info')['sections']).'</td>'
                        . '<td style="text-align:right;">'
                        . anchor(base_url().'admin/layout/widgets/'.$widget->wid.'/edit', t('Edit'), 'class="btn btn-xs btn-default"').' '
                        . (($widget->type == 'simple') ? anchor(base_url().'admin/layout/widgets/'.$widget->wid.'/delete', t('Delete'), 'class="btn btn-xs btn-danger"').' ' : '')
                        . '</td>'
                        . '</tr>';
                unset($data[$key]);
            }
        }
        else {
            $output .= '<tr>'
                    . '<td colspan="3" style="text-align:center;">'
                    . t('There are no inactive widgets')
                    . '</td>'
                    . '</tr>';
        }
        $output .= '</tbody>'
                . '</table>';
        $output .= form_button(array(
            'type' => 'submit',
            'name' => 'widgets_position_submit',
            'content' => t('Save positioning'),
            'class' => 'btn btn-sm btn-primary'
        ));
        $output .= form_close();
        return $output;
    }
    private function _prepare_admin_layout_widgets_section($section, $name, &$missing) {
        $data = $this->db->get_where('widgets', array('section' => $section))->result();
        $output = '';
        if(count($data) > 0) {
            foreach ($data as $key => $widget) {
                $output .= '<tr>'
                        . '<td style="padding-left: 2em;">'.$widget->title.'</td>'
                        . '<td style="text-align:center;">'.form_hidden(array('wid' => $widget->wid))
                        . form_dropdown('section', parse_info_file($this->theme->path_to_specifc_theme($this->configuration->get('site_theme')).'/'.$this->configuration->get('site_theme').'.info')['sections'], $widget->section).'</td>'
                        . '<td style="text-align:right;">'
                        . anchor(base_url().'admin/layout/widgets/'.$widget->wid.'/edit', t('Edit'), 'class="btn btn-xs btn-default"').' '
                        . (($widget->type == 'simple') ? anchor(base_url().'admin/layout/widgets/'.$widget->wid.'/delete', t('Delete'), 'class="btn btn-xs btn-danger"').' ' : '')
                        . '</td>'
                        . '</tr>';
                unset($data[$key]);
            }
            foreach ($data as $widget) {
                $missing[] = $widget;
            }
        }
        else {
            $output .= '<tr>'
                    . '<td colspan="3" style="text-align:center;">'
                    . t('There are no widgets in this section')
                    . '</td>'
                    . '</tr>';
        }
        return $output;
    }
    private function _prepare_admin_layout_widgets_submit() {
        $postdata = $this->input->post(NULL, TRUE);
        unset($postdata['widgets_position_submit']);
        foreach ($postdata as $data) {
            $this->db->where('wid', $data['wid']);
            if(!$this->db->update('widgets', array('section' => $data['section']))) {
                set_message(t('The widget <i>%widget</i> could not be updated', array('%widget' => $this->db->select('title')->from('widgets')->where('wid', $data['wid'])->get()->result()[0]->title)), 'error');
            }
        }
        set_message(t('Widgets were updated'), 'info');
    }
    private function _prepare_admin_layout_widgets_add() {
        if($_POST) {
            $this->_prepare_admin_layout_widgets_add_submit();
            redirect(base_url().'admin/layout/widgets');
        }
        $form = $this->load->library('form', $this->appforms->getForm('widgets_add'))->render();
        $this->wysiwyg->init();
        return $form;
    }
    private function _prepare_admin_layout_widgets_add_submit() {
        $postdata = $this->input->post(NULL, TRUE);
        unset($postdata['widgets_add_submit']);
        if($this->db->insert('widgets', $postdata)) {
            set_message(t('The new widget has been added'), 'success');
        }
        else {
            set_message(t('The new widget could not be created. Please see the error log for details'), 'error');
        }
    }
    private function _prepare_admin_layout_widgets_edit() {
        if($_POST) {
            $this->_prepare_admin_layout_widgets_edit_submit();
            redirect(base_url().'admin/layout/widgets');
        }
        $_POST = $this->db->get_where('widgets', array('wid' => $this->uri->segment(4)))->result()[0];
        $form = $this->load->library('form', $this->appforms->getForm('widgets_edit'))->render();
        $this->wysiwyg->init();
        return $form;
    }
    private function _prepare_admin_layout_widgets_edit_submit() {
        $postdata = $this->input->post(NULL, TRUE);
        unset($postdata['widgets_add_submit']);
        $this->db->where('wid', $this->uri->segment(4));
        if($this->db->update('widgets', $postdata)) {
            set_message(t('The widget has been updated'), 'success');
        }
        else {
            set_message(t('The widget could not be updated. Please see the error log for details'), 'error');
        }
    }
    private function _prepare_admin_layout_widgets_delete() {
        if($_POST) {
            $this->_prepare_admin_layout_widgets_edit_submit();
            redirect(base_url().'admin/layout/widgets');
        }
        $form = $this->load->library('form', $this->appforms->getForm('widgets_delete'))->render();
        $this->wysiwyg->init();
        return $form;
    }
    private function _prepare_admin_layout_widgets_delete_submit() {
        $postdata = $this->input->post(NULL, TRUE);
        unset($postdata['widgets_add_submit']);
        $this->db->where('wid', $this->uri->segment(4));
        if($this->db->delete('widgets')) {
            set_message(t('The widget has been deleted'), 'success');
        }
        else {
            set_message(t('The widget could not be deleted. Please see the error log for details'), 'error');
        }
    }
    private function _prepare_admin_modules() {
        
    }
    private function _prepare_admin_users() {
        
    }
    private function _prepare_admin_users_roles() {
        
    }
    private function _prepare_admin_users_permissions() {
        
    } 
    private function _prepare_admin_settings() {
        
    }
    private function _prepare_admim_reports() {
        
    }
}