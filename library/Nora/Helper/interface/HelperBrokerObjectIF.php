<?php
namespace Nora\Helper;

interface HelperBrokerObjectIF
{
	public function addHelper( $name, $helper);
	public function helper( $name );
	public function helperCall( $name, $args );
}
