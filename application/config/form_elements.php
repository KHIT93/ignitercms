<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| Form options
| -------------------------------------------------------------------
| 
| This file specifies the allowed types of form input
| that can be used in web application Form library and FormBuilder library.
| 
| These entries should not be modified without using the built-in hooks
| for extending form functionality
| 
*/
$config['form_input'] = array(
    'color',
    'date',
    'datetime',
    'datetime-local',
    'email',
    'file',
    'image',
    'month',
    'number',
    'range',
    'reset',
    'search',
    'tel',
    'text',
    'time',
    'url',
    'week'
);
$config['form_button'] = array(
    'button',
    'submit',
    'reset'
);
$config['valid_form_options'] = array();