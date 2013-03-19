<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   View
 * @package    Helper
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\View\Helper\Social;

use Nora\View\Helper;

/**
 * ヘルパー: Gravatar
 */
class Gravatar extends Helper\Placeholder
{
	/** ダイレクトメソッド */
	protected function _gravatar( $email = null)
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

	protected function _setEmeil( $email )
	{
		$this['email'] = $email;
	}

	protected function _setSize( $size )
	{
		$this['size'] = $size;
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
	protected function _setDefault( $default )
	{
		$this['default'] = $default;
		return $this;
	}

	public function toString( )
	{
		return sprintf('http://www.gravatar.com/avatar/%s?s=%s&d=%s',
			md5(strtolower($this['email'])),
			$this['size'],
			$this['default']
		);
	}

}
