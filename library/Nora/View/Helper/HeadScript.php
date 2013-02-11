<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: HeadScript
 */
class HeadScript extends Placeholder
{
	public function getSeparator( )
	{
		return PHP_EOL;
	}

	public function __invoke()
	{
		return call_user_func_array( array($this,'HeadScript'), func_get_args());
	}

	/** ダイレクトメソッド */
	public function HeadScript( $content = false, $type = 'file', $attributes=array(), $placement = 'APPEND' )
	{
		if( $content !== false )
		{
			$default = array('type'=>'text/javascript','charset'=>'utf-8', 'language'=>'javascript');

			switch( $type)
			{
			case 'file':
				$attributes = array_merge( $default, $attributes, array('src'=>$content) );
				$this->set(sprintf('<script%s></script>',$this->buildAttributes( $attributes )));
				break;
			case 'code':
				$attributes = array_merge( $default, $attributes );
				$this->set(sprintf("<script%s>\n%s\n</script>",$this->buildAttributes( $attributes ), $content));
				break;
			}
		}
		return $this;
	}

}
