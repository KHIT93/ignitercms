<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class CMS_Loader extends MX_Loader {
    /** Initialize the loader variables **/
    public function initialize($controller = NULL) {
        parent::initialize($controller);
        $this->_ci_view_paths['frontend/themes/'] = true;
        $this->_ci_view_paths['site/themes/'] = true;
    }
}