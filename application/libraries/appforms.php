<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appforms {
    private $_CI;
    private $_forms = array();
    private $_form_rules = array();
    public function __construct() {
        $this->_CI =& get_instance();
        $this->_CI->load->helper('user');
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
            '#permission' => 'admin_access_content_add',
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
                    'type' => 'markup',
                    'value' => '<hr>'
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
            '#permission' => 'admin_access_content_edit',
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
                    'type' => 'markup',
                    'value' => '<hr>'
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
            'name' => 'content_delete',
            '#permission' => 'admin_access_content_delete',
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
        $this->_forms['menus_add'] = array(
            'name' => 'menus_add',
            '#permission' => 'admin_access_layout_menus_add',
            '#elements' => array(
                array(
                    'type' => 'text',
                    'name' => 'name',
                    'class' => 'form-control',
                    'value' => set_value('name'),
                    'placeholder' => t('Menu name'),
                    'label' => array(
                        'title' => t('Menu name'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    ),
                    '#helpertext' => t('Type in the name of your menu. This will only be displayed in the administration')
                ),
                array(
                    'type' => 'text',
                    'name' => 'description',
                    'class' => 'form-control',
                    'value' => set_value('description'),
                    'placeholder' => t('Description'),
                    'label' => array(
                        'title' => t('Description'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    ),
                    '#helpertext' => t('Type in a description of your menu. This will only be displayed in the administration')
                ),
                array(
                    'type' => 'markup',
                    'value' => '<hr>'
                ),
                array(
                    'type' => 'submit',
                    'name' => 'menus_add',
                    'content' => t('Add menu'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/layout/menus',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-sm btn-default"',
                    'wrapper' => false
                )
            )
        );
        $this->_forms['menus_edit'] = array(
            'name' => 'menus_edit',
            '#permission' => 'admin_access_layout_menus_edit',
            '#elements' => array(
                array(
                    'type' => 'text',
                    'name' => 'name',
                    'class' => 'form-control',
                    'value' => set_value('name'),
                    'placeholder' => t('Menu name'),
                    'label' => array(
                        'title' => t('Menu name'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    ),
                    '#helpertext' => t('Type in the name of your menu. This will only be displayed in the administration')
                ),
                array(
                    'type' => 'text',
                    'name' => 'description',
                    'class' => 'form-control',
                    'value' => set_value('description'),
                    'placeholder' => t('Description'),
                    'label' => array(
                        'title' => t('Description'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    ),
                    '#helpertext' => t('Type in a description of your menu. This will only be displayed in the administration')
                ),
                array(
                    'type' => 'hidden',
                    'mid' => $this->_CI->uri->segment(4)
                ),
                array(
                    'type' => 'markup',
                    'value' => '<hr>'
                ),
                array(
                    'type' => 'submit',
                    'name' => 'menus_edit',
                    'content' => t('Add menu'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/layout/menus',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-sm btn-default"',
                    'wrapper' => false
                )
            )
        );
        $this->_forms['menus_delete'] = array(
            'name' => 'menus_delete',
            '#permission' => 'admin_access_layout_menus_delete',
            '#elements' => array(
                array(
                    'type' => 'hidden',
                    'mid' => $this->_CI->uri->segment(4)
                ),
                array(
                    'type' => 'submit',
                    'name' => 'menus_delete_submit',
                    'content' => t('Delete'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/layout/menus',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-sm btn-default"',
                    'wrapper' => false
                )
            )
        );
        $this->_forms['menus_links_add'] = array(
            'name' => 'menus_links_add',
            '#permission' => 'admin_access_layout_menus_links_add',
            '#elements' => array(
                array(
                    'type' => 'text',
                    'name' => 'title',
                    'class' => 'form-control',
                    'value' => set_value('title'),
                    'placeholder' => t('Title'),
                    'label' => array(
                        'title' => t('Title'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    ),
                    '#helpertext' => t('Type in the tile of your menu item. This title will be displayed in the menu')
                ),
                array(
                    'type' => 'text',
                    'name' => 'link',
                    'class' => 'form-control',
                    'value' => set_value('link'),
                    'placeholder' => t('Destination'),
                    'label' => array(
                        'title' => t('Destination'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    ),
                    '#helpertext' => t('Type in the destination for this menu item. The destination is where the visitor will end when they click the menu item')
                ),
                array(
                    'type' => 'dropdown',
                    'name' => 'position',
                    'default_value' => set_value('parent', 50),
                    'options' => range(-50, 50)
                ),
                array(
                    'type' => 'dropdown',
                    'name' => 'parent',
                    'default_value' => set_value('parent', 0),
                    'options' => menu_structure_as_strng_array($this->_CI->uri->segment(4))
                ),
                array(
                    'type' => 'markup',
                    'value' => '<hr>'
                ),
                array(
                    'type' => 'submit',
                    'name' => 'menus_links_add_submit',
                    'content' => t('Add menu item'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/layout/menus',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-sm btn-default"',
                    'wrapper' => false
                )
            )
        );
        $this->_forms['menus_links_edit'] = array(
            'name' => 'menus_links_edit',
            '#permission' => 'admin_access_layout_menus_links_add',
            '#elements' => array(
                array(
                    'type' => 'text',
                    'name' => 'title',
                    'class' => 'form-control',
                    'value' => set_value('title'),
                    'placeholder' => t('Title'),
                    'label' => array(
                        'title' => t('Title'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    ),
                    '#helpertext' => t('Type in the tile of your menu item. This title will be displayed in the menu')
                ),
                array(
                    'type' => 'text',
                    'name' => 'link',
                    'class' => 'form-control',
                    'value' => set_value('link'),
                    'placeholder' => t('Destination'),
                    'label' => array(
                        'title' => t('Destination'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    ),
                    '#helpertext' => t('Type in the destination for this menu item. The destination is where the visitor will end when they click the menu item')
                ),
                array(
                    'type' => 'dropdown',
                    'name' => 'position',
                    'default_value' => set_value('parent', 50),
                    'options' => range(-50, 50)
                ),
                array(
                    'type' => 'dropdown',
                    'name' => 'parent',
                    'default_value' => set_value('parent', 0),
                    'options' => menu_structure_as_strng_array($this->_CI->uri->segment(4))
                ),
                array(
                    'type' => 'markup',
                    'value' => '<hr>'
                ),
                array(
                    'type' => 'submit',
                    'name' => 'menus_links_edit_submit',
                    'content' => t('Save changes'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/layout/menus',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-sm btn-default"',
                    'wrapper' => false
                )
            )
        );
        $this->_forms['menus_links_delete'] = array(
            'name' => 'menus_links_delete',
            '#permission' => 'admin_access_layout_menus_delete',
            '#elements' => array(
                array(
                    'type' => 'hidden',
                    'mid' => $this->_CI->uri->segment(6)
                ),
                array(
                    'type' => 'submit',
                    'name' => 'menus_links_delete_submit',
                    'content' => t('Delete'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/layout/menus',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-sm btn-default"',
                    'wrapper' => false
                )
            )
        );
        $this->_forms['widgets_add'] = array(
            'name' => 'widgets_add',
            '#permission' => 'admin_access_layout_widgets_add',
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
                    'value' => '<label>'.t('Content').'</label>',
                ),
                array(
                    'type' => 'textarea',
                    'name' => 'content',
                    'class' => 'ckeditor',
                    'value' => set_value('content')
                ),
                array(
                    'type' => 'markup',
                    'value' => '<hr>'
                ),
                array(
                    'type' => 'submit',
                    'name' => 'widgets_add_submit',
                    'content' => t('Save'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/layout/widgets',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-sm btn-default"',
                    'wrapper' => false
                )
            )
        );
        $this->_forms['widgets_edit'] = array(
            'name' => 'widgets_edit',
            '#permission' => 'admin_access_layout_widgets_edit',
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
                    'value' => '<label>'.t('Content').'</label>',
                ),
                array(
                    'type' => 'textarea',
                    'name' => 'content',
                    'class' => 'ckeditor',
                    'value' => set_value('content')
                ),
                array(
                    'type' => 'markup',
                    'value' => '<hr>'
                ),
                array(
                    'type' => 'submit',
                    'name' => 'widgets_edit_submit',
                    'content' => t('Save'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/layout/widgets',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-sm btn-default"',
                    'wrapper' => false
                )
            )
        );
        $this->_forms['widgets_delete'] = array(
            'name' => 'widgets_delete',
            '#permission' => 'admin_access_layout_widgets_delete',
            '#elements' => array(
                array(
                    'type' => 'hidden',
                    'mid' => $this->_CI->uri->segment(6)
                ),
                array(
                    'type' => 'submit',
                    'name' => 'widgets_delete_submit',
                    'content' => t('Delete'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/layout/widgets',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-sm btn-default"',
                    'wrapper' => false
                )
            )
        );
        $this->_forms['users_add'] = array(
            'name' => 'users_add',
            '#permission' => 'admin_access_users_add',
            '#elements' => array(
                array(
                    'type' => 'text',
                    'name' => 'username',
                    'placeholder' => t('Username'),
                    'value' => set_value('username'),
                    'class' => 'form-control',
                    'label' => array(
                        'title' => t('Username'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    )
                ),
                array(
                    'type' => 'text',
                    'name' => 'name',
                    'placeholder' => t('Name'),
                    'value' => set_value('name'),
                    'class' => 'form-control',
                    'label' => array(
                        'title' => t('Name'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    )
                ),
                array(
                    'type' => 'password',
                    'name' => 'password',
                    'placeholder' => t('Password'),
                    'class' => 'form-control',
                    'label' => array(
                        'title' => t('Password'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    )
                ),
                array(
                    'type' => 'password',
                    'name' => 'confirm_password',
                    'placeholder' => t('Confirm Password'),
                    'class' => 'form-control',
                    'label' => array(
                        'title' => t('Confirm Password'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    )
                ),
                array(
                    'type' => 'markup',
                    'value' => '<legend><small>'.t('Choose user role').'</small></legend>'
                ),
                array(
                    'type' => 'dropdown',
                    'name' => 'role',
                    'default_value' => ((is_numeric($this->_CI->uri->segment(2))) ? set_user_role_id() : 4),
                    'options' => user_roles_list()
                ),
                array(
                    'type' => 'markup',
                    'value' => '<small>'.t('The role you select here decides which permissions will be assigned to the user').'</small>'
                ),
                array(
                    'type' => 'hidden',
                    'uid' => set_value('uid')
                ),
                array(
                    'type' => 'markup',
                    'value' => '<hr>'
                ),
                array(
                    'type' => 'submit',
                    'name' => 'users_add_submit',
                    'content' => t('Add user'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/users',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-sm btn-default"',
                    'wrapper' => false
                )
            )
        );
        $this->_forms['settings_general'] = array(
            'name' => 'settings_general',
            '#permission' => 'access_admin_settings_general',
            '#elements' => array(
                array(
                    'type' => 'fieldset',
                    'title' => t('Site information'),
                    '#elements' => array(
                        array(
                            'type' => 'text',
                            'name' => 'site_name',
                            'class' => 'form-control',
                            'placeholder' => 'My site name',
                            'value' => set_value('site_name'),
                            'label' => array(
                                'title' => t('Site name'),
                                '#attr' => array(
                                    'class' => 'col-sm-3 control-label no-padding-left'
                                )
                            )
                        ),
                        array(
                            'type' => 'text',
                            'name' => 'site_slogan',
                            'class' => 'form-control',
                            'placeholder' => 'Put something nice here',
                            'value' => set_value('site_slogan'),
                            'label' => array(
                                'title' => t('Slogan'),
                                '#attr' => array(
                                    'class' => 'col-sm-3 control-label no-padding-left'
                                )
                            )
                        ),
                        array(
                            'type' => 'text',
                            'name' => 'site_home',
                            'class' => 'form-control',
                            'value' => set_value('site_home'),
                            'label' => array(
                                'title' => t('Home page'),
                                '#attr' => array(
                                    'class' => 'col-sm-3 control-label no-padding-left'
                                )
                            )
                        ),
                    )
                ),
                array(
                    'type' => 'submit',
                    'name' => 'settings_general_submit',
                    'content' => t('Save changes'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/settings',
                    'value' => t('Cancel'),
                    '#attr' => 'class="btn btn-sm btn-default"',
                    'wrapper' => false
                )
            )
        );
        $this->_forms['settings_translate'] = array(
            'name' => 'settings_translate',
            '#permission' => 'access_admin_settings_translate',
            '#elements' => array(
                array(
                    'type' => 'text',
                    'name' => 'string',
                    'value' => xss_clean(set_value('string')),
                    'class' => 'form-control',
                    'label' => array(
                        'title' => t('String'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    ),
                    'readonly' => true
                ),
                array(
                    'type' => 'text',
                    'name' => 'translation',
                    'value' => xss_clean(set_value('translation')),
                    'class' => 'form-control',
                    'label' => array(
                        'title' => t('Translation'),
                        '#attr' => array(
                            'class' => 'col-sm-3 control-label no-padding-left'
                        )
                    )
                ),
                array(
                    'type' => 'submit',
                    'name' => 'settings_translate_submit',
                    'content' => t('Save changes'),
                    'class' => 'btn btn-sm btn-primary',
                    'wrapper' => false
                ),
                array(
                    'type' => 'link',
                    'href' => base_url().'admin/settings/translate',
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
        $this->_form_rules['menus'] = array(
            array(
                'field' => 'name',
                'label' => t('Name'),
                'rules' => 'required|xss_clean'
            ),
            array(
                'field' => 'description',
                'label' => t('Description'),
                'rules' => 'xss_clean'
            )
        );
        $this->_form_rules['menus_links'] = array(
            array(
                'field' => 'title',
                'label' => t('Title'),
                'rules' => 'required|xss_clean'
            ),
            array(
                'field' => 'link',
                'label' => t('Destination'),
                'rules' => 'required|xss_clean'
            )
        );
        $this->_form_rules['users_add'] = array(
            array(
                'field' => 'username',
                'label' => t('Username'),
                'rules' => 'required|xss_clean|is_unique[users.username]'
            ),
            array(
                'field' => 'password',
                'label' => t('Password'),
                'rules' => 'required|xss_clean'
            ),
            array(
                'field' => 'password_again',
                'label' => t('Confirm password'),
                'rules' => 'required|xss_clean|matches[password]'
            )
        );
        $this->_form_rules['users_edit'] = array(
            array(
                'field' => 'username',
                'label' => t('Username'),
                'rules' => 'required|xss_clean'
            ),
            array(
                'field' => 'link',
                'label' => t('Destination'),
                'rules' => 'required|xss_clean'
            )
        );
        $this->_form_rules['users_edit'] = array(
            array(
                'field' => 'username',
                'label' => t('Username'),
                'rules' => 'required|xss_clean|is_unique[roles.name]'
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