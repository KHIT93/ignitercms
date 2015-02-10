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

$config['valid_cron_intervals'] = array(
    '3600' => '1 hour',
    '10800' => '3 hours',
    '21600' => '6 hours',
    '43200' => '12 hours',
    '86400' => '1 day'
);