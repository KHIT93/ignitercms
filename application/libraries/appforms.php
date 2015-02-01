<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appforms {
    private $_CI;
    private $_forms = array();
    private $_form_rules = array();
    public function __construct() {
        $this->_CI =& get_instance();
        $this->_forms['admin_login'] = array(
            'name' => 'admin_login',
            '#permission' => 'any',
            '#elements' => array(
                array(
                    'type' => 'fieldset',
                    '#elements' => array(
                        array(
                            'type' => 'markup',
                            'value' => '<label class="block clearfix">'
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<span class="block input-icon input-icon-right">'
                        ),
                        array(
                            'type' => 'text',
                            'name' => 'username',
                            'placeholder' => t('Username'),
                            'class' => 'form-control',
                            'autocomplete' => 'off',
                            'value' => set_value('username')
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<i class="ace-icon fa fa-user"></i>'
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '</span>'
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '</label>'
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<label class="block clearfix">'
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<span class="block input-icon input-icon-right">'
                        ),
                        array(
                            'type' => 'password',
                            'name' => 'password',
                            'placeholder' => t('Password'),
                            'class' => 'form-control',
                            'value' => set_value('password')
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<i class="ace-icon fa fa-lock"></i>'
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '</span>'
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '</label>'
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<div class="space"></div>'
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<div class="clearfix">'
                        ),
                        array(
                            'type' => 'checkboxgroup',
                            '#elements' => array(
                                array(
                                    'type' => 'checkbox',
                                    'name' => 'remember',
                                    'value' => 'true',
                                    '#title' => t('Remember me')
                                ),
                            )
                        ),
                        array(
                            'type' => 'submit',
                            'class' => 'width-35 pull-right btn btn-sm btn-primary',
                            'name' => 'admin_login_submit',
                            'content' => '<i class="ace-icon fa fa-key"></i><span class="bigger-110">'.t('Log in').'</span>'
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '</div>'
                        )
                    )
                )
            )
        );
        $this->_forms['user_login'] = array(
            'name' => 'user_login',
            '#permission' => 'any',
            '#elements' => array(
                array(
                    'type' => 'text',
                    'name' => 'username',
                    'placeholder' => t('Username'),
                    'autocomplete' => 'off',
                    'value' => set_value('username')
                ),
                array(
                    'type' => 'password',
                    'name' => 'password',
                    'placeholder' => t('Password'),
                    'value' => set_value('password')
                ),
                array(
                    'type' => 'submit',
                    'name' => 'user_login_submit',
                    'content' => t('Log in')
                )
            )
        );
        $this->_forms['content_add'] = array(
            'name' => 'content_add',
            '#permission' => 'any',
            '#elements' => array(
                array(
                    'type' => 'text',
                    'name' => 'title',
                    'placeholder' => t('Title'),
                    'value' => set_value('title'),
                    'class' => 'form-control',
                    'label' => array(
                        'title' => t('Title'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    )
                ),
                array(
                    'type' => 'markup',
                    'value' => '<label>'.t('Body').'</label>',
                ),
                array(
                    'type' => 'textarea',
                    'name' => 'body',
                    'class' => 'ckeditor',
                    'value' => set_value('body')
                ),
                array(
                    'type' => 'fieldset',
                    'title' => 'SEO',
                    '#elements' => array(
                        array(
                            'type' => 'text',
                            'name' => 'head_title',
                            'placeholder' => t('Alternate title'),
                            'value' => set_value('head_title'),
                            'class' => 'form-control',
                            'label' => array(
                                'title' => t('Alternate title'),
                                '#attr' => array(
                                    'class' => 'col-sm-3 control-label no-padding-left'
                                )
                            ),
                            '#helpertext' => t('Define an alternate page title for, which will be shown in search results')
                        ),
                        array(
                            'type' => 'text',
                            'name' => 'description',
                            'placeholder' => t('Description'),
                            'value' => set_value('description'),
                            'class' => 'form-control',
                            'label' => array(
                                'title' => t('Description'),
                                '#attr' => array(
                                    'class' => 'col-sm-3 control-label no-padding-left'
                                )
                            ),
                            '#helpertext' => t('Define a short description, which will be displayed in the search results')
                        ),
                        array(
                            'type' => 'text',
                            'name' => 'keywords',
                            'placeholder' => t('Keywords'),
                            'value' => set_value('keywords'),
                            'class' => 'form-control',
                            'label' => array(
                                'title' => t('Keywords'),
                                '#attr' => array(
                                    'class' => 'col-sm-3 control-label no-padding-left'
                                )
                            ),
                            '#helpertext' => t('Define a list of keywords, seperated by commas(,) of keywords for which the page should be listed in the search results')
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<legend><small>'.t('Page indexing').'</small></legend>'
                        ),
                        array(
                            'type' => 'radiogroup',
                            '#elements' => array(
                                array(
                                    'type' => 'radio',
                                    'name' => 'index',
                                    'value' => 'index',
                                    '#title' => t('Index'),
                                    'checked' => TRUE
                                ),
                                array(
                                    'type' => 'radio',
                                    'name' => 'index',
                                    'value' => 'noindex',
                                    '#title' => t('No index')
                                )
                            )
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<small>'.t('Define if this page should be indexed by the search engines').'</small><hr>'
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<legend><small>'.t('Page follwing').'</small></legend>'
                        ),
                        array(
                            'type' => 'radiogroup',
                            '#elements' => array(
                                array(
                                    'type' => 'radio',
                                    'name' => 'follow',
                                    'value' => 'follow',
                                    '#title' => t('Follow'),
                                    'checked' => TRUE,
                                ),
                                array(
                                    'type' => 'radio',
                                    'name' => 'follow',
                                    'value' => 'nofollow',
                                    '#title' => t('No follow'),
                                ),
                            )
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<small>'.t('Define if search engines should follow the contents of the page').'</small><hr>'
                        )
                    )
                ),
                array(
                    'type' => 'submit',
                    'name' => 'content_add_submit',
                    'content' => t('Add content'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/content',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-sm btn-default"',
                    'wrapper' => false
                )
            )
        );
        $this->_forms['content_edit'] = array(
            'name' => 'content_edit',
            '#permission' => 'any',
            '#elements' => array(
                array(
                    'type' => 'text',
                    'name' => 'title',
                    'placeholder' => t('Title'),
                    'value' => set_value('title'),
                    'class' => 'form-control',
                    'label' => array(
                        'title' => t('Title'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    )
                ),
                array(
                    'type' => 'markup',
                    'value' => '<label>'.t('Body').'</label>',
                ),
                array(
                    'type' => 'textarea',
                    'name' => 'body',
                    'class' => 'ckeditor',
                    'value' => set_value('body')
                ),
                array(
                    'type' => 'fieldset',
                    'title' => 'SEO',
                    '#elements' => array(
                        array(
                            'type' => 'text',
                            'name' => 'head_title',
                            'placeholder' => t('Alternate title'),
                            'value' => set_value('head_title'),
                            'class' => 'form-control',
                            'label' => array(
                                'title' => t('Alternate title'),
                                '#attr' => array(
                                    'class' => 'col-sm-3 control-label no-padding-left'
                                )
                            ),
                            '#helpertext' => t('Define an alternate page title for, which will be shown in search results')
                        ),
                        array(
                            'type' => 'text',
                            'name' => 'description',
                            'placeholder' => t('Description'),
                            'value' => set_value('description'),
                            'class' => 'form-control',
                            'label' => array(
                                'title' => t('Description'),
                                '#attr' => array(
                                    'class' => 'col-sm-3 control-label no-padding-left'
                                )
                            ),
                            '#helpertext' => t('Define a short description, which will be displayed in the search results')
                        ),
                        array(
                            'type' => 'text',
                            'name' => 'keywords',
                            'placeholder' => t('Keywords'),
                            'value' => set_value('keywords'),
                            'class' => 'form-control',
                            'label' => array(
                                'title' => t('Keywords'),
                                '#attr' => array(
                                    'class' => 'col-sm-3 control-label no-padding-left'
                                )
                            ),
                            '#helpertext' => t('Define a list of keywords, seperated by commas(,) of keywords for which the page should be listed in the search results')
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<legend><small>'.t('Page indexing').'</small></legend>'
                        ),
                        array(
                            'type' => 'radiogroup',
                            '#elements' => array(
                                array(
                                    'type' => 'radio',
                                    'name' => 'index',
                                    'value' => 'index',
                                    '#title' => t('Index'),
                                    'checked' => TRUE
                                ),
                                array(
                                    'type' => 'radio',
                                    'name' => 'index',
                                    'value' => 'noindex',
                                    '#title' => t('No index')
                                )
                            )
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<small>'.t('Define if this page should be indexed by the search engines').'</small><hr>'
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<legend><small>'.t('Page follwing').'</small></legend>'
                        ),
                        array(
                            'type' => 'radiogroup',
                            '#elements' => array(
                                array(
                                    'type' => 'radio',
                                    'name' => 'follow',
                                    'value' => 'follow',
                                    '#title' => t('Follow'),
                                    'checked' => TRUE,
                                ),
                                array(
                                    'type' => 'radio',
                                    'name' => 'follow',
                                    'value' => 'nofollow',
                                    '#title' => t('No follow'),
                                ),
                            )
                        ),
                        array(
                            'type' => 'markup',
                            'value' => '<small>'.t('Define if search engines should follow the contents of the page').'</small><hr>'
                        )
                    )
                ),
                array(
                    'type' => 'hidden',
                    'pid' => $this->_CI->uri->segment(2)
                ),
                array(
                    'type' => 'submit',
                    'name' => 'content_edit_submit',
                    'content' => t('Edit content'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/content',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-sm btn-default"',
                    'wrapper' => false
                )
            )
        );
        $this->_forms['content_delete'] = array(
            'name' => 'content_add',
            '#permission' => 'any',
            '#elements' => array(
                array(
                    'type' => 'hidden',
                    'pid' => $this->_CI->uri->segment(2)
                ),
                array(
                    'type' => 'submit',
                    'name' => 'content_delete_submit',
                    'content' => t('Delete'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/content',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-sm btn-default"',
                    'wrapper' => false
                )
            )
        );
        //Form validation rules
        $this->_form_rules['admin_login'] = array(
            array(
                'field' => 'username',
                'label' => t('Username'),
                'rules' => 'required|xss_clean|callback_user_exists'
            ),
            array(
                'field' => 'password',
                'label' => t('Password'),
                'rules' => 'required|xss_clean'
            )
        );
        $this->_form_rules['user_login'] = array(
            array(
                'field' => 'username',
                'label' => t('Username'),
                'rules' => 'required|xss_clean|callback_user_exists'
            ),
            array(
                'field' => 'password',
                'label' => t('Password'),
                'rules' => 'required|xss_clean'
            )
        );
        $this->_form_rules['content_add'] = array(
            array(
                'field' => 'title',
                'label' => t('Title'),
                'rules' => 'required|xss_clean'
            ),
            array(
                'field' => 'body',
                'label' => t('Body'),
                'rules' => 'xss_clean'
            )
        );
        $this->_form_rules['content_edit'] = array(
            array(
                'field' => 'title',
                'label' => t('Title'),
                'rules' => 'required|xss_clean'
            ),
            array(
                'field' => 'body',
                'label' => t('Body'),
                'rules' => 'xss_clean'
            ),
            array(
                'field' => 'pid',
                'label' => t('Unique page identifier'),
                'rules' => 'required|xss_clean'
            )
        );
    }
    public function getForm($form_name) {
        if(isset($this->_forms[$form_name])) {
            return $this->_forms[$form_name];
        }
        else {
            return NULL;
        }
    }
    public function getValidationRules($form_name) {
        if(isset($this->_form_rules[$form_name])) {
            return $this->_form_rules[$form_name];
        }
        else {
            return NULL;
        }
    }
}