<?php
function traverse($array, $class = 'nav navbar-nav', $toggle = false) {
    $active = get_instance()->uri->uri_string;
    $str = '<ul class="'.$class.'">';
    foreach($array as $item) {
        if($active == $item['link']) {
            $str .= '<li class="active'.((isset($item['children'])) ? ' dropdown' : '').'"><a href="'.$item['link'].'"'.(isset($item['children'])&&$toggle==true?' class="dropdown-toggle" data-toggle="dropdown" role="button"':'').'>'.$item['title'].'</a>'.(isset($item['children'])&&$item['children']?traverse($item['children'], 'dropdown-menu'):'').'</li>';
        }
        else {
            $str .= '<li class="'.((isset($item['children'])) ? 'dropdown' : '').'"><a href="'.$item['link'].'"'.(isset($item['children'])&&$toggle==true?' class="dropdown-toggle" data-toggle="dropdown" role="button"':'').'>'.$item['title'].'</span></a>'.(isset($item['children'])&&$item['children']?traverse($item['children'], 'dropdown-menu'):'').'</li>';
        }
    }
    $str .= '</ul>';
    return $str;
}
function sidebar_traverse($array, $class = NULL, $toggle = false) {
    $CI =& get_instance();
    $active = base_url().$CI->uri->uri_string;
    $str = '<ul class="'.$class.'">';
    foreach($array as $item) {
        if($active == $item['link']) {
            $str .= '<li class="active"><a href="'.$item['link'].'"'.(isset($item['children'])&&$toggle==true?' class="dropdown-toggle" data-toggle="dropdown"':'').'>'.$item['title'].'</a>'.(isset($item['children'])&&$item['children']?traverse($item['children'], 'dropdown-menu'):'').'</li>';
        }
        else {
            $str .= '<li><a href="'.$item['link'].'"'.(isset($item['children'])&&$toggle==true?' class="dropdown-toggle" data-toggle="dropdown"':'').'>'.$item['title'].'</a>'.(isset($item['children'])&&$item['children']?sidebar_traverse($item['children'], 'submenu'):'').'</li>';
        }
    }
    $str .= '</ul>';
    return $str;
}
function stacked_traverse($array, $active, $class = NULL) {
    $str = '<ul class="'.$class.'">';
    foreach($array as $item) {
        if($active == $item['link']) {
            $str .= '<li class="active"><a href="/'.$item['link'].'"'.(isset($item['children'])&&$toggle==true?' class="dropdown-toggle" data-toggle="dropdown"':'').'>'.$item['title'].'</a>'.(isset($item['children'])&&$item['children']?traverse($item['children'], 'dropdown-menu'):'').'</li>';
        }
        else {
            $str .= '<li><a href="/'.$item['link'].'">'.$item['title'].'</a>'.(isset($item['children'])&&$item['children']?traverse($item['children'], 'dropdown stacked-dropdown'):'').'</li>';
        }
    }
    $str .= '</ul>';
    return $str;
}
if(!function_exists('add_redirect')) {
    function add_redirect($source, $destination, $type = 301) {
        $CI =& get_instance();
        if(count($CI->db->from('url_alias')->where('source', $source)->where('alias', $destination)->get()->result())) {
            set_message(t('The URL created does already exist'), 'warning');
        }
        else {
            $data = array(
                'source' => $source,
                'alias' => $destination,
                'type' => $type,
                'language' => $CI->configuration->get('site_language')
            );
            $CI->db->insert('url_alias', $data);
        }
    }
}
if(!function_exists('menu_structure_as_strng_array')) {
    function menu_structure_as_strng_array($mid) {
        $CI =& get_instance();
        $menu = $CI->db->select('*')->from('menu_links')->where('mid', $mid)->get()->result();
        $output = array();
        $output[0] = '-- '.t('Choose parent menu item').' --';
        foreach ($menu as $item) {
            $output[$item->mlid] = $item->title;
        }
        return $output;
    }
}
if(!function_exists('array_to_menu')) {
    function array_to_menu($array, $class = 'nav navbar-nav', $toggle = true) {
        $menuitems = array();
        foreach($array as $link) {
            $menuitems[] = array('id' => $link['mlid'], 'title' => $link['title'], 'parent' => $link['parent'], 'link' => $link['link']);
        }
        $tmp = array(0 => array('title' => 'root', 'children'=>array()));
        foreach($menuitems as $item) {
            $tmp[$item['id']] = isset($tmp[$item['id']]) ? array_merge($tmp[$item['id']],$item) : $item;
            $tmp[$item['parent']]['children'][] =& $tmp[$item['id']];
        }
        $db = NULL;
        $root = $tmp[0]['children'];
        return traverse($root, $class, $toggle);
    }
}