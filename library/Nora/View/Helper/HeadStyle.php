<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: HeadStyle
 */
class HeadStyle extends Placeholder
{
	public function getSeparator( )
	{
		return PHP_EOL;
	}

	public function __invoke()
	{
		return call_user_func_array( array($this,'HeadStyle'), func_get_args());
	}

	/** ダイレクトメソッド */
	public function HeadStyle( $content = false, $type = 'code', $attributes=array(), $placement = 'APPEND' )
	{
		if( $content !== false )
		{
			$default = array(
				'rel'=>'stylesheet',
				'media'=>'screen',
				'type'=>'text/css'
			);

			switch( $type)
			{
			case 'file':
				$attributes = array_merge( $default, $attributes, array('href'=>$content) );
				$this->set(sprintf('<link%s>',$this->buildAttributes( $attributes )));
				break;
			case 'code':
				$this->placeholder('code')
					->setPrefix('<style>'.PHP_EOL)
					->setPostfix(PHP_EOL.'</style>')
					->set( $content );
				break;
			}
		}
		return $this;
	}

	public function appendFile( $file )
	{
		return $this->HeadStyle( $file, 'file', array(), 'APPEND');
	}

	public function capStart()
	{
		$this->placeholder('code')->capStart();
	}
	public function capEnd()
	{
		$this->placeholder('code')->capEnd();
	}


}
