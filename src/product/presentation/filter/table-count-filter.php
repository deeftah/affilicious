<?php
namespace Affilicious\Product\Presentation\Filter;

use Affilicious\Product\Domain\Model\Product_Interface;

if (!defined('ABSPATH')) {
    exit('Not allowed to access pages directly.');
}

class Table_Count_Filter
{
    /**
     * Update the product table counts since the product variants are hidden
     *
     * @since 0.6
     * @param $views
     * @return mixed
     */
    public function filter($views)
    {
        global $current_screen, $wpdb;

        if($current_screen->id !== 'edit-' . Product_Interface::POST_TYPE) {
            return $views;
        }

        if (isset($views['all'])) {
            $all = $wpdb->get_var("
            SELECT COUNT(*)
            FROM $wpdb->posts
            WHERE post_status IN ('publish', 'draft', 'pending') 
            AND post_type = '" . Product_Interface::POST_TYPE . "'
            AND post_parent = 0"
            );

            $views['all'] = preg_replace('/\(.+\)/U', '(' . $all . ')', $views['all']);
        }

        if (isset($views['publish'])) {
            $publish = $wpdb->get_var("
            SELECT COUNT(*)
            FROM $wpdb->posts
            WHERE post_status = 'publish'
            AND post_type = '" . Product_Interface::POST_TYPE . "'
            AND post_parent = 0"
            );

            $views['publish'] = preg_replace('/\(.+\)/U', '(' . $publish . ')', $views['publish']);
        }

        if (isset($views['draft'])) {
            $draft = $wpdb->get_var("
            SELECT COUNT(*)
            FROM $wpdb->posts
            WHERE post_status = 'draft'
            AND post_type = '" . Product_Interface::POST_TYPE . "'
            AND post_parent = 0"
            );

            $views['draft'] = preg_replace('/\(.+\)/U', '(' . $draft . ')', $views['draft']);
        }

        if (isset($views['pending'])) {
            $pending = $wpdb->get_var("
            SELECT COUNT(*)
            FROM $wpdb->posts
            WHERE post_status = 'pending'
            AND post_type = '" . Product_Interface::POST_TYPE . "'
            AND post_parent = 0"
            );

            $views['pending'] = preg_replace('/\(.+\)/U', '(' . $pending . ')', $views['pending']);
        }

        if (isset($views['trash'])) {
            $trash = $wpdb->get_var("
            SELECT COUNT(*)
            FROM $wpdb->posts
            WHERE post_status = 'trash'
            AND post_type = '" . Product_Interface::POST_TYPE . "'
            AND post_parent = 0"
            );

            $views['trash'] = preg_replace('/\(.+\)/U', '(' . $trash . ')', $views['trash']);
        }

        return $views;
    }
}
