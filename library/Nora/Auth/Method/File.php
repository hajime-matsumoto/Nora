<?php
namespace Nora\Auth\Method;

class File extends Method
{
	private $_auth_file;

	public function init( )
	{
		$this->setAuthFileName( $this->getOption('authFile') );
	}

	public function setAuthFileName( $file )
	{
		$this->_auth_file = $file;
	}

	public function auth( $user, $passwd )
	{
		$fp = fopen( $this->_auth_file, 'r');
		flock($fp,LOCK_SH);
		$result = false;
		while( $line = fgets($fp) )
		{
			$line_user = trim(strtok( $line, ':'));
			if( $line_user ==  $user )
			{
				$line_passwd = trim(strtok(':'));
				if( $line_passwd == $passwd )
				{
					$result = true;
				}
			}
		}
		flock($fp,LOCK_UN);
		fclose($fp);
		return $result;
	}

}
