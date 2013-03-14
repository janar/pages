<?php

/**
 * Code executed when bundle is started
 */

// Shortcut to bundle path
$path = Bundle::path('pages');

// Create autoloader map
Autoloader::map(
    array(
        'Pages_Admin_Base_Controller' => $path . 'controllers/admin/base.php',
        )
    );

// Create autoloader namespaces
Autoloader::namespaces(
    array(
        'Pages\Models' => $path . 'models',
        'Pages' => $path . 'libraries',
        )
    );