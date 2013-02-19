<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: Doctype
 */
class Gravatar extends Placeholder
{
	/** ダイレクトメソッド */
	public function Gravatar( $email = null)
	{
		if( $email != null )
		{
			$this->setEmeil( $email );
		}
		return $this;
	}

	public function __construct( )
	{
		$this->setSize('200')->setDefault('mm');
	}

	public function setEmeil( $email )
	{
		$this['email'] = $email;
		return $this;
	}

	public function setSize( $size )
	{
		$this['size'] = $size;
		return $this;
	}

	/*
	 * デフォルトイメージ
	 *
	 * mm: (mystery-man) a simple, cartoon-style silhouetted outline of a person (does not vary by email hash)
	 * identicon: a geometric pattern based on an email hash
	 * monsterid: a generated 'monster' with different colors, faces, etc
	 * wavatar: generated faces with differing features and backgrounds
	 * retro: awesome generated, 8-bit arcade-style pixelated faces
	 * blank: a transparent PNG image (border added to HTML below for demonstration purposes)
	 */
	public function setDefault( $default )
	{
		$this['default'] = $default;
		return $this;
	}

	public function __toString( )
	{
		return sprintf('http://www.gravatar.com/avatar/%s?s=%s&d=%s',
			md5(strtolower($this['email'])),
			$this['size'],
			$this['default']
		);
	}

}
