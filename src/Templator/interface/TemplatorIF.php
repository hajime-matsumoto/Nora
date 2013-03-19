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
namespace Nora\Templator;

use Nora\General;
use Nora\General\Helper;

/**
 * テンプレータ用インターフェイス 
 */
interface TemplatorIF extends Helper\BrokerOwnerIF,General\SetupableIF
{
}
