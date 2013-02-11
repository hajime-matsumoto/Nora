<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: HeadScript
 */
class HeadScript
{
	use HelperTool;

	private $_scripts = array();

	/** ダイレクトメソッド */
	public function HeadScript( $content = false, $attributes = array(), $type = 'file', $placement = 'APPEND' )
	{
		if( $content == false )
		{
			return $this;
		}
		$default = array('type'=>'text/javascript','charset'=>'utf-8', 'language'=>'javascript');
		switch( $type )
		{
		case 'file':
			$script = array(
				'type'       => 'file',
				'attributes' => array_merge( $default, $attributes,  array('src' => $content ) )
			);
			break;
		case 'code':
			$script = array(
				'type'       => 'code',
				'code'       => $content,
				'attributes' => array_merge( $default, $attributes )
			);
			break;

		}
		if($placement == 'APPEND')
		{
			array_push($this->_scripts, $script);
		}
		else
		{
			array_unshift( $this->_scripts, $script );
		}
		return $this;
	}

	public function toString( )
	{
		$html = "";
		foreach( $this->_scripts as $script )
		{
			switch( $script['type'] )
			{
			case 'file':
				$html .= '<script';
				foreach( $script['attributes'] as $k=>$v )
				{
					$html.= sprintf(' %s="%s"', $k, $v );
				}
				$html.= '></script>'.PHP_EOL;
				break;
			case 'code':
				$html .= '<script';
				foreach( $script['attributes'] as $k=>$v )
				{
					$html.= sprintf(' %s="%s"', $k, $v );
				}
				$html.= '>'.PHP_EOL;
				$html.= $script['code'];
				$html.= PHP_EOL.'</script>';
				break;
			}
		}
		return $html;
	}
}
