<?php
namespace Nora\Mailer;

class Mailer
{
	public function smtp( $host, $port, $user, $passwd )
	{
		$this->getSmtp()->setUp($host,$port,$user,$passwd);
	}

	public function sendQue( $mail )
	{
		$this->getSmtp()->sendQue( $mail );
	}
}
