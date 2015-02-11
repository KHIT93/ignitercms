<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'models/mdl_admin.php';

class Mdl_Admin_Settings extends Mdl_Admin {
    public function __construct() {
        parent::__construct();
    }
    
    protected function _prepare_admin_settings() {
        $data = array(
            'categories' => array(
                'system' => array('name' => t('System')),
                'content' => array('name' => t('Content management')),
                'seo' => array('name' => t('Search & metadata')),
                'maintenance' => array('name' => t('Development and maintenance')),
                'regional' => array('name' => t('Regional settings'))
            ),
            'items' => array(
                'system' => array(
                    array(
                        'title' => t('General options'),
                        'description' => t('Configure general settings'),
                        'link' => 'admin/settings/general'
                    ),
                    array(
                        'title' => t('Scheduled tasks'),
                        'description' => t('Manage scheduled tasks, that are typically performed using Cron jobs'),
                        'link' => 'admin/settings/cron'
                    )
                ),
                'content' => array(
                    array(
                        'title' => t('WYSIWYG options'),
                        'description' => t('Configure settings for the WYSIWYG editor'),
                        'link' => 'admin/settings/wysiwyg'
                    ),
                    array(
                        'title' => t('Text formats & filtering'),
                        'description' => t('Manage the text formats available for this website and any filters that are applied to content when inserting and outputting it to the users'),
                        'link' => 'admin/settings/textformats'
                    )
                ),
                'seo' => array(
                    array(
                        'title' => t('URL Redirect'),
                        'description' => t('Manage URL redirects for content'),
                        'link' => 'admin/settings/redirect'
                    ),
                    array(
                        'title' => t('SEO tags'),
                        'description' => t('Mange SEO tags as fx. keywords and description'),
                        'link' => 'admin/settings/seo'
                    )
                ),
                'maintenance' => array(
                    array(
                        'title' => t('Maintenance'),
                        'description' => t('Manage the maintenance setttings for the website'),
                        'link' => 'admin/settings/maintenance'
                    ),
                    array(
                        'title' => t('Caching'),
                        'description' => t('Manage caching for your website'),
                        'link' => 'admin/settings/cache'
                    )
                ),
                'regional' => array(
                    array(
                        'title' => t('Language'),
                        'description' => t('Choose which language your website uses'),
                        'link' => 'admin/settings/language'
                    ),
                    array(
                        'title' => t('Translation'),
                        'description' => t('Translate the user interface and text displayed by installed modules and themes'),
                        'link' => 'admin/settings/translate'
                    )
                )
            )
        );
        return $this->load->view('view_admin_settings', $data, TRUE);
    }
    protected function _prepare_admin_settings_general() {
        if(count($_POST)) {
            //submit changes
            $update_batch = array(
                array(
                    'property' => 'site_name',
                    'contents' => $this->input->post('site_name', TRUE)
                ),
                array(
                    'property' => 'site_slogan',
                    'contents' => $this->input->post('site_slogan', TRUE)
                ),
                array(
                    'property' => 'site_home',
                    'contents' => $this->input->post('site_home', TRUE)
                )
            );
            if($this->db->update_batch('config', $update_batch, 'property')) {
                set_message(t('Settings have been updated'), 'success');
            }
            else {
                set_message(t('Site setting could not be updated. Please see the error log for details'), 'error');
            }
        }
        $_POST = array(
            'site_name' => $this->configuration->get('site_name'),
            'site_slogan' => $this->configuration->get('site_slogan'),
            'site_home' => $this->configuration->get('site_home')
        );
        $this->_data->title = t('General options');
        $output = array(
            'content' => '',
            'form' => $this->load->library('form', $this->appforms->getForm('settings_general'))->render()
        );
        return $this->load->view('view_admin_settings_general', $output, TRUE);
    }
    
    protected function _prepare_admin_settings_redirect() {
        $action = $this->uri->segment(5);
        if(!is_null($action)) {
            if($action == 'add') {
                return $this->_prepare_admin_settings_redirect_add();
            }
            else if($action == 'edit') {
                return $this->_prepare_admin_settings_redirect_edit();
            }
            else if($action == 'delete') {
                return $this->_prepare_admin_settings_redirect_delete();
            }
        }
        $this->_data->title = t('URL Redirects');
        $data = array(
            'redirects' => $this->db->get('url_alias')->result()
        );
        return $this->load->view('view_admin_settings_redirect', $data, TRUE);
    }
    
    protected function _prepare_admin_settings_redirect_add() {
        if(count($_POST)) {
            $postdata = $this->input->post(NULL, TRUE);
            unset($postdata['settings_redirect_add_submit']);
            if($this->db->insert('url_alias', $postdata)) {
                set_message(t('New redirect was added'), 'success');
            }
            else {
                set_message(t('The new redirect could not be added'), 'error');
            }
        }
        return $this->load->library('form', $this->appforms->getForm('settings_redirect_add'))->render();
    }
    
    protected function _prepare_admin_settings_redirect_edit() {
        if(count($_POST)) {
            $postdata = $this->input->post(NULL, TRUE);
            unset($postdata['settings_redirect_add_submit']);
            $this->db->where('aid', $this->uri->segment(4));
            if($this->db->update('url_alias', $postdata)) {
                set_message(t('The redirect was updated'), 'success');
            }
            else {
                set_message(t('The redirect could not be updated'), 'error');
            }
        }
        $_POST = $this->db->get_where('url_alias', array('aid' => $this->uri->segment(5)))->result_array();
        return $this->load->library('form', $this->appforms->getForm('settings_redirect_add'))->render();
    }
    
    protected function _prepare_admin_settings_redirect_delete() {
        if(count($_POST)) {
            $this->db->where('aid', $this->uri->segment(4));
            if($this->db->delete('url_alias')) {
                set_message(t('The redirect was delted'), 'success');
            }
            else {
                set_message(t('The redirect could not be deleted'), 'error');
            }
        }
        return $this->load->library('form', $this->appforms->getForm('settings_redirect_delete'))->render();
    }

    protected function _prepare_admin_settings_cron() {
        if(count($_POST)) {
            $this->db->where('property', 'cron_interval');
            if($this->db->update('config', array('contents' => $this->input->post('cron_interval', TRUE)))) {
                set_message(t('Interval for execution of scheduled tasks has been changed'), 'success');
            }
            else {
                set_message(t('Interval for execution of scheduled tasks could not be changed'), 'error');
            }
        }
        $this->_data->title = t('Scheduled tasks');
        $data = array(
            'form' => $this->load->library('form', $this->appforms->getForm('settings_cron_schedule'))->render()
        );
        return $this->load->view('view_admin_settings_cron', $data, TRUE);
    }
    
    protected function _prepare_admin_settings_translate() {
        $tid = $this->uri->segment(4);
        if(is_numeric($tid)) {
            //This is the editing page for translations
            if(count($_POST)) {
                $this->db->where('tid', $tid);
                if($this->db->update('translation', array('translation' => $this->input->post('translation', TRUE)))) {
                    set_message (t('Translation has been updated'), 'success');
                }
                else {
                    set_message(t('Translation was not updated. Please see the error log for details'), 'error');
                }
                redirect(base_url().'admin/settings/translate');
            }
            $data = $this->db->get_where('translation', array('tid' => $tid))->result_array()[0];
            $_POST = array(
                'string' => $data['string'],
                'translation' => $data['translation']
            );
            $output = array('form' => $this->load->library('form', $this->appforms->getForm('settings_translate'))->render());
            return $this->load->view('view_admin_settings_translate', $output, TRUE);
        }
        else {
            //list all strings in the translations table for the current language
            return $this->load->view('view_admin_settings_translate_list', array('translations' => $this->db->get_where('translation', array('language' => $this->configuration->get('site_language')))->result()), TRUE);
        }
    }
}