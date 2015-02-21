<?php
/***
 * ErrorPage class
 * Author: Caleb Lee
 *
 * This class represents an error page, only accessed when the user goes to a page=
 *	that does not exist.
 ***/
 
 class ErrorView {
 	public function output() {
 		return "<p>This page does not exist.</p>";
 	}
 }
?>