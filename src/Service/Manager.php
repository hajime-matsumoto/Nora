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
namespace Nora\Service;

require_once 'Service/interface/ManagerIF.php';
require_once 'Service/trait/ManagerTrait.php';

/**
 * サービスマネージャー
 */
class Manager implements ManagerIF
{
	use ManagerTrait;
}
