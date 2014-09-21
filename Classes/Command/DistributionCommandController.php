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

		foreach ($this->getCacheTables() as $cacheTable) {
			$command = sprintf('%s -u %s -p%s -e "TRUNCATE table %s;" %s',
				$this->getMysqlBinary(),
				$this->getUsername(),
				$this->getPassword(),
				$cacheTable,
				$this->getDatabase()
			);
			exec($command);
		}

		$tables = array_keys($GLOBALS['TCA']);
		$command = sprintf('mysqldump -u root -proot %s %s > %sext_tables_static+adt.sql',
			$this->getDatabase(),
			implode(' ', $tables),
			ExtensionManagementUtility::extPath('speciality_distribution')
		);

		exec($command);

		$this->outputLine('File has been written at:');
		$this->outputLine(ExtensionManagementUtility::extPath('speciality_distribution') . 'ext_tables_static+adt.sql');
	}


	/**
	 * Returns the cache tables.
	 *
	 * @return array
	 */
	public function getCacheTables() {

		$cacheTables = array(
			#'be_sessions',
			'cache_imagesizes',
			'sys_log',
			'sys_lockedrecords',
			'sys_history',
			#'sys_registry',
			'sys_file_processedfile',
			'sys_refindex',
			'tx_extensionmanager_domain_model_extension',
		);

		// Get a list of cache table which should be cleared beforehand and merge them into the $tables variable.
		$tablePrefixes = array(
			'cf_',
			'index_',
			'tx_realurl_',
		);

		foreach ($tablePrefixes as $prefix) {
			$result = array();

			$request = sprintf("SELECT GROUP_CONCAT(DISTINCT table_name) FROM information_schema.tables WHERE table_schema = '%s' AND table_name like '%s%%';",
				$this->getDatabase(),
				$prefix
			);
			$command = sprintf('%s -u %s -p%s -e "%s"',
				$this->getMysqlBinary(),
				$this->getUsername(),
				$this->getPassword(),
				$request
			);

			// get the result
			exec($command, $result);

			if (!empty($result[1]) && $result[1] != 'NULL') {
				$cacheTables = array_merge($cacheTables, explode(',', $result[1]));
			}

		}
		return $cacheTables;
	}
	/**
	 * @return string
	 */
	protected function getDatabase() {
		return $GLOBALS['TYPO3_CONF_VARS']['DB']['database'];
	}

	/**
	 * @return string
	 */
	public function getUsername() {
		return $GLOBALS['TYPO3_CONF_VARS']['DB']['username'];
	}

	/**
	 * @return string
	 */
	public function getPassword() {
		return $GLOBALS['TYPO3_CONF_VARS']['DB']['password'];
	}

	/**
	 * @return string
	 */
	public function getMysqlBinary() {
		return 'mysql';
	}
}
