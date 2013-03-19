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

/**
 * アプリケーションモジュール
 */
trait ApplicationTrait
{
    use ModuleTrait

    protected $namespace_key       = 'app.namespace';
    protected $dirname_key         = 'app.dirname';
    protected $defaultBootstrapper = 'Nora\Package\ApplicationBootstrapper';
}
