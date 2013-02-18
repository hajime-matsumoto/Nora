<?php
/**
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */

namespace Nora\DI;

abstract class Container implements ContainerObjectIF,ComponentObjectIF
{
	use ComponentObject, ContainerObject;
}
