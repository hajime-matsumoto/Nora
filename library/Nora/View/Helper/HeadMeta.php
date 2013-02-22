<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: HeadMeta
 */
class HeadMeta extends Placeholder
{
	private $_metas = array();

	public function __construct( )
	{
		$this->placeholder('charset')->setFormat('<meta charset="%s">'.PHP_EOL);
		$this->placeholder('name')->setFormat('<meta name="%s" content="%s">'.PHP_EOL);
		$this->placeholder('http-equiv')->setFormat('<meta http-equiv="%s" content="%s">'.PHP_EOL);
		$this->placeholder('property')->setFormat('<meta property="%s" content="%s">'.PHP_EOL);
	}

			//"<meta name=\"keyword\" content=\"hajime,matsumoto,hp\">\n<meta name=\"description\" content=\"これは、のらホームページです\">\n<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">\n<meta charset=\"utf-8\">\n<meta property=\"og:title\" content=\"Facebook用のタイトル\">\n",
	/** ダイレクトメソッド */
	public function HeadMeta( $content = false, $value = false, $type = 'name', $attributes = array(), $placement = 'APPEND' )
	{
		if( $content != false )
		{
			$this->placeholder($type)->add( array( $content, $value ), $placement );
		}
		return $this;
	}

	public function setProperty( $key, $value )
	{
		return $this->HeadMeta( $key, $value, 'property', 'APPEND');
	}
	public function appendProperty( $key, $value )
	{
		return $this->HeadMeta( $key, $value, 'property', 'APPEND');
	}
	public function prependProperty( $key, $value )
	{
		return $this->HeadMeta( $key, $value, 'property', 'PREPEND');
	}

	public function setCharset( $charset )
	{
		return $this->HeadMeta( $charset, false, 'charset' );
	}

	public function appendHttpEquiv( $key, $value, $attributes = array() )
	{
		return $this->HeadMeta( $key, $value, 'http-equiv', $attributes, 'APPEND' );
	}

	public function prependHttpEquiv( $key, $value, $attributes = array() )
	{
		return $this->HeadMeta( $key, $value, 'http-equiv', $attributes, 'PREPEND' );
	}

	public function appendName( $key, $value, $attributes = array() )
	{
		return $this->HeadMeta( $key, $value, 'name', $attributes, 'APPEND' );
	}

	public function prependName( $key, $value, $attributes = array() )
	{
		return $this->HeadMeta( $key, $value, 'name', $attributes, 'PREPEND' );
	}
}
