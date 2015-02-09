<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form {
    private $_CI;
    private $_form;
    
    public function __construct($form) {
        $this->_CI =& get_instance();
        $this->_form = $form;
    }
    public function render() {
        //return $this->_CI->load->view($this->theme->tpl_path('form').'/form/form.tpl.php', array('form' =>$this->_render), true);
        return $this->_prepare();
    }
    private function _prepare() {
        $form = '<div class="messages">'.validation_errors().'</div>';
        $form .= (isset($this->_form['#multipart']) && $this->_form['#multipart'] == TRUE) ? form_open_multipart('', ((isset($this->_form['#attr'])) ? $this->_form['#attr'] : '')): form_open('', ((isset($this->_form['#attr'])) ? $this->_form['#attr'] : ''));
        foreach ($this->_form['#elements'] as $element) {
            $form .= $this->_prepare_element($element);
        }
        $form .= form_close();
        return $form;
    }
    protected function _prepare_element($element = array()) {
        if(count($element)) {
            $output = ($element['type'] != 'markup' && (!isset($element['wrapper']) || $element['wrapper'] == true)) ? '<div class="form-group">' : '';
            if(isset($element['label'])) {
                $output .= form_label($element['label']['title'], $element['name'], $element['label']['#attr']);
                unset($element['label']);
            }
            if(isset($element['value']) && (in_array($element['type'], $this->_CI->config->config['form_input']) || $element['type'] == 'textarea')) {
                $element['value'] = set_value($element['name']);
            }
            if(in_array($element['type'], $this->_CI->config->config['form_input'])) {
                $output .= form_input($element);
            }
            else if($element['type'] == 'checkbox') {
                $output .= $this->_prepare_checkbox($element);
            }
            else if($element['type'] == 'radio') {
                $output .= $this->_prepare_radio($element);
            }
            else if($element['type'] == 'hidden') {
                unset($element['type']);
                $output .= form_hidden($element);
                $element['type'] = 'hidden';
            }
            else if($element['type'] == 'file') {
                $output .= form_upload($element);
            }
            else if($element['type'] == 'password') {
                $output .= form_password($element);
            }
            else if($element['type'] == 'dropdown') {
                $output .= form_dropdown($element['name'], $element['options'], ((isset($element['default_value']) ? $element['default_value'] : NULL)));
            }
            else if($element['type'] == 'textarea') {
                $output .= form_textarea($element);
            }
            else if($element['type'] == 'fieldset') {
                $output .= $this->_prepare_fieldset($element);
            }
            else if($element['type'] == 'label') {
                $output .= $this->_prepare_label($element);
            }
            else if($element['type'] == 'link') {
                $output .= anchor($element['href'], $element['value'], $element['#attr']);
            }
            else if($element['type'] == 'markup') {
                $output .= $element['value'];
            }
            else if($element['type'] == 'radiogroup') {
                $output .= $this->_prepare_radiogroup($element);
            }
            else if($element['type'] == 'checkboxgroup') {
                $output .= $this->_prepare_checkboxgroup($element);
            }
            else if(in_array($element['type'], $this->_CI->config->config['form_button'])) {
                $output .= form_button($element);
            }
            else {
                //return t('The field <i>@field</i> could not be rendered', array('@field' => $element['type']));
                return krumo($element);
            }
            $output .= (isset($element['#helpertext'])) ? '<small>'.$element['#helpertext'].'</small>' : '';
            $output .= ($element['type'] != 'markup' && (!isset($element['wrapper']) || $element['wrapper'] == true)) ? '</div>' : (($element['type'] == 'markup') ? '' : '&nbsp; &nbsp;');
            return $output;
        }
        else {
            return NULL;
        }
    }
    private function _prepare_element_input($element) {
        
        /*switch ($element['type']) {
                case :
                    return $this->_prepare_element_input($element);
                break;
                case 'checkbox':
                    return form_checkbox($element);
                break;
                case 'radio':
                    return form_radio($element);
                break;
                case 'hidden':
                    return form_hidden($element);
                break;
                case 'password':
                    return form_password($element);
                break;
                case 'dropdown':
                    return form_dropdown($element['name'], $element['#options'], $element['#selected']);
                break;
                case 'textarea':
                    return form_textarea($element);
                break;
                case 'fieldset':
                    return $this->_prepare_fieldset($element);
                break;
                case 'label':
                    return $this->_prepare_label($element);
                break;
                case 'link':
                    return anchor($element['href'], $element['value'], $element['#attr']);
                break;
                case 'markup':
                    return $element['value'];
                break;
                case (in_array($element['type'], $this->_CI->config->config['form_button'])):
                    return form_button($element);
                break;
                default:
                    return t('The field <i>@field</i> could not be rendered', array('@field' => $element['type']));
                break;
            }*/
    }
    protected function _prepare_fieldset($fieldset) {
        $fieldset_data = form_fieldset(((isset($fieldset['title'])) ? $fieldset['title'] : ''), ((isset($fieldset['#attr'])) ? $fieldset['#attr'] : ''));
        foreach ($fieldset['#elements'] as $element) {
            $fieldset_data .= $this->_prepare_element($element);
        }
        $fieldset_data .= form_fieldset_close();
        return $fieldset_data;
    }
    protected function _prepare_radio($element) {
        $output = '<div class="radio">';
        $output .= form_label(form_radio($element).'<span class="lbl">'.$element['#title'].'</span>');
        $output .= '</div>';
        return $output;
    }
    protected function _prepare_radiogroup($element) {
        $output = '';
        foreach ($element['#elements'] as $radio) {
            $title = $radio['#title'];
            unset($radio['#title']);
            $output .= form_label(form_radio($radio).$title, '', array('class' => 'radio-inline'));
        }
        $output .= '';
        return $output;
    }
    protected function _prepare_checkbox($element) {
        $output = '<div class="checkbox">';
        $output .= form_label(form_checkbox($element).'<span class="lbl">'.$element['#title'].'</span>');
        $output .= '</div>';
        return $output;
    }
    protected function _prepare_checkboxgroup($element) {
        $output = '';
        foreach ($element['#elements'] as $radio) {
            $title = $radio['#title'];
            unset($radio['#title']);
            $output .= form_label(form_checkbox($radio).$title, '', array('class' => 'checkbox-inline'));
        }
        $output .= '';
        return $output;
    }
    protected function _prepare_label($element) {
        if(is_array($element['content'])) {
            $content_data = '';
            foreach ($element as $content) {
                $content_data .= $this->_prepare_element($content);
            }
            return form_label($content_data, $element['for'], ((isset($element['#attr'])) ? $element['#attr'] : ''));
        }
        else {
            return form_label($element['content'], $element['for'], $element['#attr']);
        }
    }
}