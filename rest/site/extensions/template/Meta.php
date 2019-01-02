<?php
use prodigyview\template\Template;
use prodigyview\network\Router;
use prodigyview\system\Libraries;

/**
 * An extension for managing the meta information(title, keywords, descriptions,etc)of the current page.
 */
class Meta {
	
	/**
	 * Gets the title of the website.
	 * 
	 * @return string
	 */
	public function getTitle() {
		return Template::getSiteTitle();
	}
	
	/**
	 * Sets the title of the site.
	 * 
	 * @param string $title
	 * 
	 * @return void
	 */
	public function setTitle($title) {
		Template::setSiteTitle($title);
	}
	
	/**
	 * Appends text to the current page title
	 * 
	 * @param string $title
	 * 
	 * @return void
	 */
	public function appendTitle($title) {
		Template::appendSiteTitle($tile);
	}
	
	/**
	 * Gets the meta description of the site
	 * 
	 * @return string
	 */
	public function getDescription() {
		return Template::getSiteMetaDescription();
	}
	
	/**
	 * Sets the meta description of the site.
	 * 
	 * @param string $description
	 * 
	 * @return void
	 */
	public function setDescription($description) {
		Template::setSiteMetaDescription($description);
	}
	
	/**
	 * Gets the meta tags for the website
	 * 
	 * @return string
	 */
	public function getTags() {
		return Template::getSiteMetaTags();
	}
	
	/**
	 * Sets the meta tags for the current page
	 * 
	 * @param string $tags
	 * 
	 * @return void
	 */
	public function setTags($tags) {
		Template::setSiteMetaTags($tags);
	}
	
	/**
	 * Adds more tags to the current page
	 * 
	 * @param string $tags
	 * 
	 * @return void
	 */
	public function appendTags($tags) {
		Template::appendSiteMetaTags($tags);
	}
	
	/**
	 * Adds a javascript library to be included on this page.
	 * 
	 * @param string $script A relative or absolute path to a script
	 * 
	 * @return void
	 */
	public function addJavascript($script) {
		Libraries::enqueueJavascript($script);
	}
	
	/**
	 * Adds a css file to be included on this page.
	 * 
	 * @param string $script A relative or absolute path to a css file
	 * 
	 * @return void
	 */
	public function addCss($script) {
		Libraries::enqueueCss($script);
	}
	
	/**
	 * Adds javascript that is not a file but server on the page.
	 * 
	 * @param string $script A complete script to serve on the current page
	 * 
	 * @return void
	 */
	public function addOpenJavascript($script) {
		Libraries::enqueueOpenscript($script);
	}
	
}
