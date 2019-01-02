<?php
/**
 * The bootstrap is divided in various files that control different aspects of the system. They are ordered in a way that best suites
 * the system. The files and orders can be modified at will depending on your needs. 
 * 
 * IMPORTANT: For a succesful bootstrap, make sure the structure.php of the system is always first.
 */
include_once PV_ROOT.DS.'app/config/config.php';
//include_once 'bootstrap/database.php';
include_once 'bootstrap/libraries.php';
include_once 'bootstrap/sessions.php';
include_once 'bootstrap/security.php';
include_once 'bootstrap/validation.php';
include_once PV_ROOT.DS.'app/config/validation.php';
include_once 'bootstrap/template.php';
//include_once 'bootstrap/mail.php';
include_once 'bootstrap/cache.php';
include_once 'bootstrap/media.php';
include_once 'bootstrap/router.php';