<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: Doctype
 */
class Gravatar
{
	use HelperTool;

	private $_email, $_size = 200, $_default = 'mm';

	/** ダイレクトメソッド */
	public function Gravatar( $email )
	{
		$this->setEmeil( $email );
		return $this;
	}

	public function setEmeil( $email )
	{
		$this->_email = $email;
		return $this;
	}
	public function setSize( $size )
	{
		$this->_size = $size;
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
		$this->_default = $default;
	}

	public function toString( )
	{
		return sprintf('http://www.gravatar.com/avatar/%s?s=%s&d=%s',
			md5(strtolower($this->_email)),
			$this->_size,
			$this->_default
		);
	}

}
