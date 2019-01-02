<?php

use app\models\basic\Posts;
use app\models\basic\ContactSubmissions;
use app\services\session\SessionService;

include('baseController.php');

/**
 * Empty control for if a user navigates to a page that does not exist.
 */
class errorController extends baseController {
	

	public function index() : array  {
		
		return $this ->error404();
	}
	
}
