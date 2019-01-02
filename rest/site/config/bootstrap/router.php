<?php
/**
 * The router allows customization of the uri in Helium. To effectively utilize, make sure the .htaccess file is in place
 * if you are using Apache or have the path following enabled in Nginx.
 */

 
/*
 * Initialize the router and configure how the route is parsed. Add adapters, filters
 * and observers to the router. Add routes to the router.
 */
use prodigyview\network\Router;

Router::init(array());

//Basic Router, mimics that the basics of an MVC
Router::addRouteRule(array('rule'=>'/:controller'));
Router::addRouteRule(array('rule'=>'/:controller/:action'));
Router::addRouteRule(array('rule'=>'/:controller/:action/:id'));

//Optional Rule Example - Shorten urls by only requiring controller and id
//Router::addRouteRule(array('rule'=>'/:controller/:id', 'route' => array('action' => 'view')));

//Optional Rule Example - Have UUID be routed to a view to shorten the users
//Router::addRouteRule(array('rule'=>'/:controller/[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}', 'route' => array('action' => 'view')));

//Optional Rule Example - For SEO have text in the url
//Router::addRouteRule(array('rule'=>'/:controller/:action/:text/:id'));

Router::addRouteRule(array('rule'=>'', 'route'=>array('controller'=>'index', 'action'=>'index')));
Router::addRouteRule(array('rule'=>'/', 'route'=>array('controller'=>'index', 'action'=>'index')));

//Custom Routes
Router::addRouteRule(array('rule'=>'/register', 'route'=>array('controller'=>'users', 'action'=>'register')));
Router::addRouteRule(array('rule'=>'/login', 'route'=>array('controller'=>'users', 'action'=>'login')));
Router::addRouteRule(array('rule'=>'/logout', 'route'=>array('controller'=>'users', 'action'=>'logout')));
Router::addRouteRule(array('rule'=>'/profile/:id', 'route'=>array('controller'=>'users', 'action'=>'profile')));
Router::addRouteRule(array('rule'=>'/contact', 'route'=>array('controller'=>'index', 'action'=>'contact')));









