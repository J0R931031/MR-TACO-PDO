<?php
namespace proyecto\Response;

class Success extends Response {

function __construct($data = NULL){
	$this->message = 'Si jaló, tilín :D';
	$this->data = $data;
}//

};// end class alanpich\REST\HTTP\Response\Success
