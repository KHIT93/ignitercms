<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
        public function __construct() {
            parent::__construct();
        }
        public function index($pid = NULL, $additional = NULL)
	{
            if($this->uri->uri_string == '' || $this->uri->uri_string == NULL) {
                $this->uri->uri_string = $this->configuration->get('site_home');
            }
            if($this->uri->segment(1) == 'content' && is_numeric($this->uri->segment(2)) && !is_null($this->uri->segment(3))) {
                switch ($this->uri->segment(3)) {
                    case 'edit':
                        $this->edit($pid);
                    break;
                    case 'delete':
                        $this->delete($pid);
                    break;
                    default:
                        break;
                }
            }
            else if($this->uri->segment(1) == 'content' && is_numeric($this->uri->segment(2))) {
                $this->db->select('alias')->from('url_alias')->where('source', $this->uri->uri_string);
                redirect($this->db->get()->result()[0]->alias, 'location', 301);
            }
            else {
                $this->load->model('mdl_content', 'node');
                $data = $this->node->prepare();
                $this->load->view($this->theme->tpl_path('base').'/base.tpl.php', $data);
            }
	}
        public function add() {
            if($this->user->is_logged_in()) {
                if($_POST) {
                    $this->_add_submit();
                }
                $this->config->config['force_admin_theme'] = TRUE;
                //Renders the add content form
                $this->load->model('mdl_admin', 'node');
                $data = new stdClass();
                $data->head_title = t('Content Management');
                $data->title = t('Content');
                $data = $this->node->prepare('content_add', $data);
                $this->load->view($this->theme->tpl_path('base', $this->configuration->get('admin_theme')).'/base.tpl.php', $data);
            }
            else {
                show_error(t('You are not authorized to view this page'), 403, t('Access Denied'));
            }
        }
        private function _add_submit() {
            $this->load->library('form_validation');
            //Set validation rules
            $this->form_validation->set_rules($this->appforms->getValidationRules('content_add'));
            if($this->form_validation->run($this)) {
                //Creates the new page
                $postdata = $this->input->post(NULL, TRUE);
                
                if(isset($postdata['index']) && isset($postdata['follow'])) {
                    $postdata['robots'] = $postdata['index'].','.$postdata['follow'];
                    unset($postdata['index']);
                    unset($postdata['follow']);
                }
                unset($postdata['content_add_submit']);
                $postdata['created'] = date("Y-m-d");
                $postdata['last_updated'] = $postdata['created'];
                $postdata['author'] = $this->session->userdata('uid');
                if($this->db->insert('pages', $postdata)) {
                    if($this->db->insert('url_alias', array('source' => 'content/'.$this->db->insert_id(), 'alias' => url_title(strtolower($postdata['title'])), 'language' => $this->configuration->get('site_language')))) {
                        set_message(t('The new page <i>%page</i> was successfully created', array('%page' => $postdata['title'])), 'success');
                    }
                    else {
                        set_message(t('The new page <i><%page</i> was created, however a valid URL could not be made. See the log for details', array('%page' => $postdata['title'])), 'warning');
                    }
                    redirect(base_url().'admin/content');
                }
            }
        }
        public function edit($page_id) {
            if($this->user->is_logged_in()) {
                if($_POST) {
                    $this->_edit_submit();
                }
                $this->config->config['force_admin_theme'] = TRUE;
                //Renders the edit content form
                $this->load->model('mdl_admin', 'node');

                $data = new stdClass();
                $data->head_title = t('Edit content');
                //$data->title = t('Edit <i>%node</i>', array('%node' => $this->db->select('title')->from('pages')->where('pid', $this->uri->segment(2))->get()->result()[0]->title));
                $data->title = t('Edit <i>%page</i>', array('%page' => $this->db->select('title')->from('pages')->where('pid', $this->uri->segment(2))->get()->result()[0]->title));
                $data = $this->node->prepare('content_edit', $data);
                $this->load->view($this->theme->tpl_path('base', $this->configuration->get('admin_theme')).'/base.tpl.php', $data);
            }
        }
        private function _edit_submit() {
            $this->load->library('form_validation');
            //Set validation rules
            $this->form_validation->set_rules($this->appforms->getValidationRules('content_edit'));
            if($this->form_validation->run($this)) {
                //Creates the new page
                $postdata = $this->input->post(NULL, TRUE);
                
                if(isset($postdata['index']) && isset($postdata['follow'])) {
                    $postdata['robots'] = $postdata['index'].','.$postdata['follow'];
                    unset($postdata['index']);
                    unset($postdata['follow']);
                }
                unset($postdata['content_add_submit']);
                $postdata['last_updated'] = date("Y-m-d");
                $this->db->where('pid', $postdata['pid']);
                if($this->db->update('pages', $postdata)) {
                    if($this->db->select('alias')->from('url_alias')->where('source', 'content/'.$postdata['pid'])->get()->result[0]->alias != url_title(strtolower($postdata['title']))) {
                        if($this->db->insert('url_alias', array('source' => 'content/'.$this->db->insert_id(), 'alias' => url_title(strtolower($postdata['title'])), 'language' => $this->configuration->get('site_language')))) {
                            set_message(t('The page <i>%page</i> was successfully updated', array('%page' => $postdata['title'])), 'success');
                        }
                        else {
                            set_message(t('The page <i><%page</i> was updated, however the URL for the page could not be updated. See the log for details', array('%page' => $postdata['title'])), 'warning');
                        }
                    }
                    else {
                        set_message(t('The page <i>%page</i> was successfully updated', array('%page' => $postdata['title'])), 'success');
                    }
                    redirect(base_url().'admin/content');
                }
            }
        }
        public function delete($page_id) {
            $this->config->config['force_admin_theme'] = TRUE;
            //Renders the delete content confirmation page
            $this->load->model('mdl_admin', 'node');
            $data = new stdClass();
            $data->head_title = t('Content Management');
            $data->title = t('Content');
            $data = $this->node->prepare('content_delete', $data);
            $this->load->view($this->theme->tpl_path('base', $this->configuration->get('admin_theme')).'/base.tpl.php', $data);
        }
}

/* End of file content.php */
/* Location: ./application/controllers/content.php */