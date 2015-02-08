<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'models/mdl_admin.php';

class Mdl_Admin_Layout extends Mdl_Admin {
    public function __construct() {
        parent::__construct();
    }
    
    protected function _prepare_admin_layout() {
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
    protected function _prepare_admin_layout_content_types() {
        //To do
    }
    protected function _prepare_admin_layout_menus() {
        $output['data'] = $this->db->get('menus')->result();
        
        return $this->load->view('view_admin_layout_menus', $output, TRUE);
    }
    protected function _prepare_admin_layout_menus_add() {
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
    protected function _prepare_admin_layout_menus_edit() {
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
    protected function _prepare_admin_layout_menus_links() {
        $output['data'] = $this->db->select('*')->from('menu_links')->where('mid', $this->uri->segment(4))->get()->result();
        
        return $this->load->view('view_admin_layout_menus_links', $output, TRUE);
    }
    protected function _prepare_admin_layout_menus_links_add() {
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
    protected function _prepare_admin_layout_menus_links_edit() {
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
    protected function _prepare_admin_layout_menus_links_delete() {
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
    protected function _prepare_admin_layout_menus_delete() {
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
    protected function _prepare_admin_layout_themes() {
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
        return $this->load->view('view_admin_layout_themes', array('data' => $data), TRUE);
    }
    protected function _prepare_admin_layout_widgets() {
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
                        . '<td>'.form_hidden(array('wid['.$widget->wid.']' => $widget->wid))
                        . form_dropdown('section['.$widget->wid.']', parse_info_file($this->theme->path_to_specifc_theme($this->configuration->get('site_theme')).'/'.$this->configuration->get('site_theme').'.info')['sections']).'</td>'
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
                $output .= $this->load->view('view_admin_layout_widgets_section',array('widget' => $widget), TRUE);
                unset($data[$key]);
            }
            foreach ($data as $widget) {
                $missing[] = $widget;
            }
        }
        else {
            $output .= $this->load->view('view_admin_layout_widgets_section_no_widgets', array(), TRUE);
        }
        return $output;
    }
    private function _prepare_admin_layout_widgets_submit() {
        $postdata = $this->input->post(NULL, TRUE);
        unset($postdata['widgets_position_submit']);
        foreach ($postdata as $key => $data) {
            $this->db->where('wid', $postdata[$key]['wid']);
            if(!$this->db->update('widgets', array('section' => $postdata[$key]['section']))) {
                set_message(t('The widget <i>%widget</i> could not be updated', array('%widget' => $this->db->select('title')->from('widgets')->where('wid', $data['wid'])->get()->result()[0]->title)), 'error');
            }
        }
        set_message(t('Widgets were updated'), 'info');
    }
    protected function _prepare_admin_layout_widgets_add() {
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
    protected function _prepare_admin_layout_widgets_edit() {
        if($_POST) {
            $this->_prepare_admin_layout_widgets_edit_submit();
            redirect(base_url().'admin/layout/widgets');
        }
        $_POST = $this->db->get_where('widgets', array('wid' => $this->uri->segment(4)))->result_array()[0];
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
    protected function _prepare_admin_layout_widgets_delete() {
        if($_POST) {
            $this->_prepare_admin_layout_widgets_delete_submit();
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
}