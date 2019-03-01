<?php

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete options
delete_option('aic_block_option');
delete_option('aic_block_counter');

// Delete options in Multisite
delete_site_option('aic_block_option');
delete_site_option('aic_block_counter');
