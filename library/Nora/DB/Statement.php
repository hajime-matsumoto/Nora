<?php
/**
 * のらライブラリ
 */
namespace Nora\DB;

use Nora;


/**
 * クエリステートメント
 */
class Statement implements \Iterator
{
	private $_result;
	private $_handler;
	private $_iterator_current = false;
	private $_index;

	public function setResult( $result )
	{
		$this->_result = $result;
	}

	public function setHandler( $handler )
	{
		$this->_handler = $handler;
	}

	public function fetch( )
	{
		return $this->_handler->fetch( $this->_result );
	}

	public function fetchColumn( )
	{
		return $this->_handler->fetchColumn( $this->_result );
	}


	/** Iterator::rewind */
	public function rewind( )
	{
		$this->_index = 0;
		return $this->_iterator_current = $this->fetch();
	}

	/** Iterator::key */
	public function key()
	{
		return $this->_index++;
	}

	/** Iterator::current */
	public function current()
	{
		return $this->_iterator_current;
	}

	/** Iterator::next */
	public function next()
	{
		$this->_index++;
		return $this->_iterator_current = $this->fetch();
	}

	/** Iterator:valid */
	public function valid( )
	{
		return $this->_iterator_current ? true: false;
	}


}
