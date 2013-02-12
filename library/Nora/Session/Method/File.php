<?php
namespace Nora\Session\Method;

class File extends Method
{
	private function _getSessionFileDir( )
	{
		return '/tmp';
	}

	private function _getSessionFileName( $session_key )
	{
		return $this->_getSessionFileDir( ). '/nora-session-'. $session_key;
	}

	public function checkSessionKey( $session_key )
	{
		return file_exists( $this->_getSessionFileName( $session_key ) );
	}

	/**
	 * セッションキーを使用中に登録する
	 *
	 * もし使用中ならFALSEを返す
	 */
	public function registerSessionKey( $session_key )
	{
		if( $this->checkSessionKey( $session_key ) )
		{
			return false;
		}
		touch( $this->_getSessionFileName( $session_key ) );
		return true;
	}

	public function saveSessionData( $session_key, $session_data )
	{
		file_put_contents( $this->_getSessionFileName( $session_key ), serialize( $session_data )  );
	}

	public function restroreSessionData( $session_key )
	{
		$data =  unserialize( file_get_contents( $this->_getSessionFileName( $session_key ) ) );
		if(empty($data))
		{
			return array();
		}
		return $data;
	}

	public function destroySessionData( $session_key )
	{
		unlink( $this->_getSessionFileName( $session_key ) );
	}
}
