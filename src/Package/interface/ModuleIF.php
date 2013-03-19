<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 * テストファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, nora project all rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正bsdライセンス
 * @version    $id$
 */

namespace Nora\Package;

use Nora\General;
use Nora\Service;
use Nora\Bootstrap;

/**
 * モジュールインターフェイス
 */
interface ModuleIF extends General\ParamHolderIF,Service\InitializableIF,Bootstrap\BootstrapperOwnerIF
{
}

