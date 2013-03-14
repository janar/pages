<?php

/**
 * Base Admin controller for Pages
 */

class Pages_Admin_Base_Controller extends Admin_Base_Auth_Controller {

    public function __construct ()
    {
        parent::__construct();
        Event::listen('admin.tabs', function (&$admin_tabs) {
            $tab_items = array(
                array('Pages Management', 'admin::pages'),
                array('Create Page', 'admin::pages.create'),
                array('Categories Management', 'admin::pages.categories'),
                array('Create Category', 'admin::pages.categories.create'),
                );
            foreach($tab_items as $row) {
                $admin_tabs->add($row);
            }
        });
    }

}