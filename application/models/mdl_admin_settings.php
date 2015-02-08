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
            'form' => $form = $this->load->library('form', $this->appforms->getForm('settings_general'))->render()
        );
        return $this->load->view('view_admin_settings_general', $output, TRUE);
    }
}