<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\App;

use Nora\Service;

/**
 * リクエストクラス
 */
class Request extends \ArrayObject implements RequestIF
{
    use RequestTrait;

    public function __construct( $uri, $datas = array( ) )
    {
        $this->setParam('request_uri', $uri);
        parent::__construct( $datas );
    }

}
