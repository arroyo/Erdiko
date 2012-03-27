<?php
/**
 * Handler
 * Base request handler, All handlers should inherit this class.
 * 
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2012, Arroyo Labs, http://www.arroyolabs.com
 * @author	   John Arroyo
 */
namespace erdiko\core;
use Erdiko;

class Handler extends \ToroHandler 
{
    // public function __construct() { }
	
	public function theme($data)
	{
		$theme = Erdiko::getTheme();
		$theme->theme($data);
	}
	
    public function get($name = null, $arguments = null)
	{
		error_log("name: ".$name);
		error_log("arguments: ".$arguments);
		
		$data = array(
			'header' => array(
				'content' => "Header",
				'tagline' => "Booyah",
				'site_name' => "My Hello World Site",
			),
			'footer' => array(
				'content' => "Footer",
				'links' => array('link 1', 'link 2', 'link 3'),
			),
			'layout' => array(
				'columns' => 1,
			),
			'main_content' => "Hello World...",
			'title' => "Home Page Title",
			'sidebar' => array(
				array(
					'block_title' => 'block 1',
					'block_content' => 'blah blah blah...',
				),
			),
		);
		
		$this->theme($data);
	}
}
