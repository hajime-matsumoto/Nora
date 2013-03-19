<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @category   Web
 * @package    Request
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Web;

use Nora\General;

/**
 * リクエストクラス
 */
class Request extends General\ArrayObject
{
    private $_request_uri;
    private $_document_root;
    private $_post;
    private $_get;

    public function __construct( )
    {
        parent::__construct( array_merge( $_GET, $_POST ) );

        $this->_post = $_POST;
        $this->_get  = $_GET;


        if( isset($_SERVER['REDIRECT_URI'] ) )
        {
            $this->_request_uri = $_SERVER['REDIRECT_URI'];
        }

        if( isset($_SERVER['REQUEST_URI'] ) )
        {
            $this->_request_uri = $_SERVER['REQUEST_URI'];
        }

        if( isset($_SERVER['DOCUMENT_ROOT']) )
        {
            $this->_document_root = $_SERVER['DOCUMENT_ROOT'];
        }
    }

    public function getRequestURI( )
    {
        return $this->_request_uri;
    }

    public function getDocumentRoot( )
    {
        return $this->_document_root;
    }
}
