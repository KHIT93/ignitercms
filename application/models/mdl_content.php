<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Content extends CI_Model {
    protected $_data;
    protected $_return;
    protected $_theme_data;
    public function __construct() {
        parent::__construct();
        $this->load->helper('theme');
        $this->load->helper('menu');
        $this->_theme_data = parse_info_file($this->theme->path_to_theme().'/'.$this->theme->current().'.info');
        $this->_data = new stdClass();
    }
    public function prepare($static_data = NULL) {
        if(is_object($static_data)) {
            $this->_data = $static_data;
        }
        else {
            $this->_prepare_data();
        }
        $this->_return['head_title'] = $this->_prepare_head_title();
        $this->_return['head'] = $this->_prepare_head()."\n";
        $this->_return['styles'] = $this->_prepare_head_styles();
        $this->_return['page_top'] = '';
        $this->_return['page'] = $this->_prepare_page();
        $this->_return['page_bottom'] = '';
        $this->_return['scripts'] = (isset($this->_theme_data['scripts'])) ? $this->_prepare_scripts(): '';
        return $this->_return;
    }
    private function _prepare_data() {
        $this->db->select('source')->from('url_alias')->where('alias', $this->uri->uri_string);
        $source_uri = explode('/', $this->db->get()->result()[0]->source);
        $this->db->select('*')->from('pages')->where('pid', $source_uri[1]);
        $this->_data = $this->db->get()->result()[0]; //Get data from DB for requested page
    }
    protected function _prepare_head() {
        $head[] = '<meta charset="utf-8">';
        $head[] = '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />';
        $head[] = '<meta name="viewport" content="width=device-width, initial-scale=1">';
        return implode("\n\x20\x20\x20\x20", $head);
    }
    protected function _prepare_head_title() {
        return ((isset($this->_data->head_title) && !is_null($this->_data->head_title) && $this->_data->head_title != '') ? $this->_data->head_title : $this->_data->title).' - '.$this->configuration->get('site_name');
    }
    protected function _prepare_head_styles() {
        $rendered_styles = $this->_mandatory_head_styles();
        if(is_array($this->_theme_data['styles'])) {
            foreach ($this->_theme_data['styles'] as $media => $data) {
                for ($i=0; $i<count($data); $i++) {
                    $rendered_styles .= "\x20\x20\x20\x20".'<link href="'.base_url().$this->theme->path_to_theme().'/'.$data[$i].'" rel="stylesheet" type="text/css" media="'.$media.'">'."\n";
                }
            }
        }
        else {
            $rendered_styles .= '';
        }
        return $rendered_styles;
    }
    private function _mandatory_head_styles() {
        $rendered_styles = '';
        $rendered_styles .= '<link href="'.base_url().'frontend/core/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen">'."\n";
        $rendered_styles .= "\x20\x20\x20\x20".'<link href="'.base_url().'frontend/core/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="screen">'."\n";
        return $rendered_styles;
    }
    protected function _prepare_page() {
        $sections = array();
        foreach ($this->_theme_data['sections'] as $section => $name) {
            $sections[$section] = $this->_prepare_page_section($section);
        }
        return $this->load->view($this->theme->tpl_path('page').'/page.tpl.php', array('page' => $sections, 'site_name' => $this->configuration->get('site_name'), 'breadcrumb' => breadcrumb((count($this->uri->segments)) ? $this->uri->segments: array(0 => $this->configuration->get('site_home')))), true);
    }
    protected function _prepare_page_section($section) {
        $this->db->select('*')->from('widgets')->where('section', $section)->order_by('position', 'ASC');
        $rendered_section = array(
            'widgets' => ''
        );
        $widgets = $this->db->get()->result();
        if(count($widgets)) {
            foreach ($widgets as $widget) {
                $rendered_section['widgets'] .= $this->_prepare_page_section_widget($widget);
            }
        }
        else {
            $rendered_section['widgets'] = '';
        }
        return ($rendered_section['widgets'] != '') ? $this->load->view($this->theme->tpl_path('section').'/section.tpl'.EXT, $rendered_section, true) : '';
    }
    protected function _prepare_page_section_widget($widget) {
        if($widget->section == 'content' && $widget->content == '{"func":"PAGE"}') {
            //load tpl to for rendering primary content
            $data['title'] = $this->_data->title;
            $data['content'] = (isset($this->_data->body) ? $this->_data->body : $this->_data->content);
            return $this->load->view($this->theme->tpl_path('node').'/node.tpl.php', $data, true);
        }
        else {
            //Determine if the widget has content that is rendered by a module
            $widget_contents = $widget->content;
            if(isJson($widget->content)) {
                $widget_data = json_decode($widget->content, TRUE);
                if(isset($widget_data['module'])) {
                    $widget_contents = Modules::run($widget_data['module'].'/_widget');
                }
            }
            //load normal widget tpl file
            return $this->load->view($this->theme->tpl_path('widget').'/widget.tpl.php', array('content' => $widget_contents), true);
        }
    }
    protected function _prepare_scripts() {
        $rendered_jscripts = $this->_mandatory_scripts();
        if(is_array($this->_theme_data['scripts'])) {
            foreach ($this->_theme_data['scripts'] as $data) {
                $rendered_jscripts .= '<script src="'.base_url().$this->theme->path_to_theme().'/'.$data.'"></script>'."\n";
            }
            if($this->config->config['load_wysiwyg'] == TRUE) {
                $this->wysiwyg->implement($rendered_jscripts);
            }
        }
        else {
            $rendered_jscripts .= '';
        }
        return $rendered_jscripts;
    }
    private function _mandatory_scripts() {
        $rendered_jscripts = '';
        $rendered_jscripts .= '<script src="'.base_url().'frontend/core/js/jquery.min.js"></script>'."\n";
        $rendered_jscripts .= '<script src="'.base_url().'frontend/core/js/bootstrap.min.js"></script>'."\n";
        return $rendered_jscripts;
    }
    public function page_not_found() {
        //Renders a 404 Not Found error page
    }
    public function access_denied() {
        //Renders a 403 Access Denied error page
    }
    private function _validate_page() {
        //Checks the URL agains the database in order to validate the content behind
        //and determines if the page displayed should be 200 OK
        //or 404 Not Found
    }
}