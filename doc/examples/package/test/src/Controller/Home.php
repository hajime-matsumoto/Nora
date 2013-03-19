<?php
namespace NoraPKG\Controller;

use Nora\Controller;
use Nora\Request;
use Nora\Response;

class Home extends Controller\ActionController
{
    public function IndexAction( Request\RequestIF $request = null, Response\ResponseIF $response = null )
    {
        echo 'hello wild';
    }
}
