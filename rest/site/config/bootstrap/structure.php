<?php
/**
 * Helium use's ProdigyView Constants which are used to set the location of key attributes on the system. Values
 * that are changed here have to reflect changes in the actualy file system. This file should be included first.
 */

/**
 * Javascript & CSS File Locations
 */
//Define Javascript ROOT
define('PV_JAVASCRIPT', '/js/');
//Define JQuery Root
define('PV_ADMIN_JAVASCRIPT', 'js');
//Define JQuery Root
define('PV_JQUERY', '/assets/js/');
//Define Prototype Root
define('PV_ADMIN_JQUERY', '/assets/js/');
//Define Prototype Root
define('PV_PROTOTYPE', '/assets/js/');
//Define Prototype Root
define('PV_ADMIN_PROTOTYPE', '/assets/js/');
//Define Mootools Root
define('PV_MOOTOOLS', '/assets/js/');
//Define Mootools Root
define('PV_ADMIN_MOOTOOLS', '/assets/js/');
//Define CSS Root
define('PV_CSS', '/assets/css/');
//Define CSS Root
define('PV_ADMIN_CSS', '/assets/css/');

/**
 * Media Files Locations
 */
//Define Image Directory
define('PV_IMAGE', '/media/images/');
//Define Video Directory
define('PV_VIDEO', '/media/video/');
//Define Audio Directory
define('PV_AUDIO', '/media/audio/');
//Define Audio Directory
define('PV_FILE', '/media/files/');

/**
 * Applications and Plugin Locations
 */
//Define Applications Directory
define('PV_APPLICATIONS', SITE_PATH.DS.'apps'.DS.'front'.DS);
//Define Applications Admin Directory
define('PV_ADMIN_APPLICATIONS', SITE_PATH.DS.'apps'.DS.'admin'.DS);
//Define Plugins Directory
define('PV_PLUGINS',  SITE_PATH.DS.'plugins'.DS);
//Define is Admin
define('PV_IS_ADMIN', TRUE);