<?php
namespace Vanilla\SpecialityDistribution\Command;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012-2013 Fabien Udriot <fabien.udriot@typo3.org>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;

/**
 * Command Controller which handles actions related to Speciality Distribution.
 */
class DistributionCommandController extends CommandController {

	/**
	 * Export database and create a SQL dump file at EXT:speciality_distribution/ext_tables_static+adt.sql
	 *
	 * @return void
	 */
	public function exportCommand() {

		$this->outputLine('Exporting to SQL dump...');

		$tables = array_keys($GLOBALS['TCA']);
		$command = sprintf('mysqldump -u root -proot bootstrapfab %s > %sext_tables_static+adt.sql',
			implode(' ', $tables),
			ExtensionManagementUtility::extPath('speciality_distribution')
		);

		exec($command);

		$this->outputLine('File has been written at:');
		$this->outputLine(ExtensionManagementUtility::extPath('speciality_distribution') . 'ext_tables_static+adt.sql');
	}
}
