<?php

if (!defined('ABSPATH')) {
	exit;
}

function esret_fs_is_parent_active_and_loaded() {
    // Check if the parent's init SDK method exists.
    return function_exists( 'esr_fs' );
}

function esret_fs_is_parent_active() {
    $active_plugins = get_option( 'active_plugins', array() );

    if ( is_multisite() ) {
        $network_active_plugins = get_site_option( 'active_sitewide_plugins', array() );
        $active_plugins         = array_merge( $active_plugins, array_keys( $network_active_plugins ) );
    }

    foreach ( $active_plugins as $basename ) {
        if ( 0 === strpos( $basename, 'easy-school-registration/' ) ||
            0 === strpos( $basename, 'easy-school-registration-premium/' )
        ) {
            return true;
        }
    }

    return false;
}

function esret_fs_init() {
    if ( esret_fs_is_parent_active_and_loaded() ) {
        // Init Freemius.
        esret_fs();


        // Signal that the add-on's SDK was initiated.
        do_action( 'esret_fs_loaded' );

        // Parent is active, add your init code here.

    } else {
        // Parent is inactive, add your error handling here.
    }
}

if ( esret_fs_is_parent_active_and_loaded() ) {
    // If parent already included, init add-on.
    esret_fs_init();
} else if ( esret_fs_is_parent_active() ) {
    // Init add-on only after the parent is loaded.
    add_action( 'esr_fs_loaded', 'esret_fs_init' );
} else {
    // Even though the parent is not activated, execute add-on for activation / uninstall hooks.
    esret_fs_init();
}