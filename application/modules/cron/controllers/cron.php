<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        
    }
    public function execute($cron_key = NULL) {
        //Executes the cron tasks
        if(!$cron_key && $this->user->is_logged_in()) {
            Modules::run('permission/_validate', 'acess_admin_cron_execute');
            //Execute cron
            $this->_invoke('_cron');
            print 'cron was executed using user session validation';
        }
        else {
            $db_key = $this->configuration->get('cron_key');
            if($cron_key == $db_key) {
                //Execute cron
                $this->_invoke('_cron');
                print 'cron was executed using cron key validation';
                
            }
            else {
                show_error(t('You are not authorized to perform this action. This might be caused by an invalid key or insufficient permissions'), 403, t('Access Denied'));
            }
        }
    }
}