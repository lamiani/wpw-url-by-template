<?php
/**
 * Created by PhpStorm.
 * User: damianstebel
 * Date: 24.10.2016
 * Time: 21:55
 */

/**
 * @param string $name of the template file ex. about.php
 * @param boolean $web if true return full URL else only the site ID
 * @return mixed string/int page url or id. # if not found
 */
function wpw_url_by_template($name, $web = true)
{
    //direct query
    global $wpdb;
    $id = sprintf("SELECT post_id FROM `%spostmeta` WHERE `meta_value` = '%s'", $wpdb->prefix, $name);

    $get_id = $wpdb->get_var($id);
    if ($get_id) {
        if ($web) {
            //support for the language plugin - polylang (https://wordpress.org/plugins/polylang/)
            if (function_exists('pll_get_post')) {
                $lang_id = pll_get_post($get_id);
                $link = get_page_link($lang_id);
            } else {
                $link = get_page_link($get_id);
            }
            $ret = isset($link) ? $link : '#';
        } else {
            $ret = $get_id;
        }
    } else {
        $ret = '#';
    }

    return $ret;
}