<?php
namespace Nora\View\Helper\Social\Mixi;

use Nora\Helper;
use Nora\Collection;
/**
 * ヘルパー: MixiLike
 */
class Like implements Helper\HelperObjectIF
{
	use Helper\HelperObject;
	use Collection\AutoPropSet;

	protected $_dataPluginsType='mixi-favorite';
	protected $_dataServiceKey;
	protected $_dataSize='medium';
	protected $_dataHref='';
	protected $_dataShowFaces='false';
	protected $_dataShowCount='true';
	protected $_dataShowComment='true';
	protected $_dataWidth='';

	protected $_format =
		'<div data-plugins-type=":dataPluginsType" data-service-key=":dataServiceKey" data-size=":dataSize" data-href=":dataHref" data-show-faces=":dataShowFaces" data-show-count=":dataShowCount" data-show-comment=":dataShowComment" data-width=":dataWidth"></div>';

	public function __construct( $view )
	{
		$this->_view = $view;
		$this->_view->footScript('(function(d) {var s = d.createElement(\'script\'); s.type = \'text/javascript\'; s.async = true;s.src = \'//static.mixi.jp/js/plugins.js#lang=ja\';d.getElementsByTagName(\'head\')[0].appendChild(s);})(document);');
	}

	public function __toString( )
	{
		return $this->autoPropFormat( $this->_format );
	}

	public function Like( $dataServiceKey = null)
	{
		if( $dataServiceKey !=  null )
		{
			$this->setDataServiceKey( $dataServiceKey );
		}
		return $this;
	}
}
