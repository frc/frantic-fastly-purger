<?php

namespace Frantic;

class FastlyPurger {
    private $fastly;
    function __construct() {
        \add_action('clean_post_cache', array($this,'action_clean_post_cache'), 100);
        /*
        ** Example: direct FastlyAPI call.
        **
        \add_action('edit_post', array($this,'action_edit_post'), 100);
        $this->fastly = new \Fastly\API();
        $this->fastly->AuthKey(getenv('FASTLY_API_KEY') || \get_option('fastly_api_key'));
        */
    }
    /*
    function action_edit_post( $post_id ) {
       $this->fastly->API_purge(get_option('home'));
    }
    */
    function action_clean_post_cache($post_id) {
        $post = \get_post($post_id);
        if ( empty( $post ) || $post->post_type == 'revision' || \get_post_status($post_id) != 'publish' )
                return;
        \do_action('fastly_purge_url', \get_option('home'));
        \do_action('fastly_purge_url', \trailingslashit(\get_option('home')));
        \do_action('fastly_purge_url', \get_permalink($post_id));
    }
}
