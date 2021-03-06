<?php
/**
 * Resolve creating custom db tables during install.
 *
 * @package ludwigspeedup
 * @subpackage build
 */

/* define package name */
define('PKG_NAME','LudwigSpeedUp');
define('PKG_NAME_LOWER',strtolower(PKG_NAME));
define('PKG_TABLE_PREFIX', PKG_NAME_LOWER .'_');

if ($object->xpdo) 
{
	switch ($options[xPDOTransport::PACKAGE_ACTION]) 
	{
		case xPDOTransport::ACTION_INSTALL:
			$modx =& $object->xpdo;
			$modelPath = $modx->getOption('core_path').'components/'. PKG_NAME_LOWER .'/model/';
			$modx->addPackage( PKG_NAME_LOWER, $modelPath, PKG_TABLE_PREFIX);

			$manager = $modx->getManager();
			$manager->createObjectContainer('LogTimings');

			break;

		case xPDOTransport::ACTION_UPGRADE:
			break;

		case xPDOTransport::ACTION_UNINSTALL:
			$modx =& $object->xpdo;
			$modelPath = $modx->getOption('core_path').'components/'. PKG_NAME_LOWER .'/model/';
			if ( $modx->addPackage( PKG_NAME_LOWER, $modelPath, PKG_TABLE_PREFIX) )
			{
				$manager = $modx->getManager();
				$manager->removeObjectContainer('LogTimings');
			}
			break;

	}
}
return true;
