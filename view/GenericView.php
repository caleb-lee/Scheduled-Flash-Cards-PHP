<?php
/***
 * GenericView class
 * Author: Caleb Lee
 *
 * This class represents a generic page view template. It has a title 
 *	and a body and can output them. The purpose of this is to make sure all views have
 *	a unified look and to keep the look the same by editing only one file. All views
 *	should inherit from GenericView.
 ***/

abstract class GenericView {
	public $title;
	public $body;
	
	public function output() {
		$output = "<h3>" . $this->title . "</h3>" . $this->body;
		
		return $output;
	}
}

?>