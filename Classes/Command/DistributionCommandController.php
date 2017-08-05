<?php
namespace Abteilung\SpecialityDistribution\Command;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;

/**
 * Command Controller which handles actions related to Speciality Distribution.
 */
class DistributionCommandController extends CommandController
{

    /**
     * Export database and create a SQL dump file at EXT:speciality_distribution/ext_tables_static+adt.sql
     *
     * @return void
     */
    public function exportCommand()
    {

        $this->truncateCacheTables();
        $this->cleanUpDeletedRecords();
        $this->flushUserPreferences();
        $this->stripLanguageDiff();

        $this->outputLine('Exporting to SQL dump...');

        $tableWithKeys = $GLOBALS['TCA'];
        unset($tableWithKeys['tx_vidi_selection']);
        unset($tableWithKeys['tx_rtehtmlarea_acronym']);

        $tables = array_keys($tableWithKeys);
        $tables[] = 'tx_scheduler_task'; // Add this special table.
        $tables[] = 'sys_category_record_mm'; // Add this special table.

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
     * @return void
     */
    protected function flushUserPreferences()
    {
        $this->outputLine('Flush user preferences...');
        $this->getDatabaseConnection()->sql_query('UPDATE be_users SET uc = ""');
    }

    /**
     * @return void
     */
    protected function stripLanguageDiff()
    {
        $this->outputLine('Remove language diff...');
        $this->getDatabaseConnection()->sql_query('UPDATE sys_file_metadata SET l10n_diffsource = ""');
        $this->getDatabaseConnection()->sql_query('UPDATE sys_file_reference SET l10n_diffsource = ""');
        $this->getDatabaseConnection()->sql_query('UPDATE sys_category SET l10n_diffsource = ""');

        $this->getDatabaseConnection()->sql_query('UPDATE pages_language_overlay SET l18n_diffsource = ""');
        $this->getDatabaseConnection()->sql_query('UPDATE tt_content SET l18n_diffsource = ""');
    }

    /**
     * @return void
     */
    protected function cleanUpDeletedRecords()
    {

        $this->outputLine('Cleaning up deleted records...');

        $tableNames = [
            'tt_content',
            'pages',
            'pages_language_overlay',
            'sys_file_reference',
        ];

        foreach ($tableNames as $tableName) {
            $query = sprintf(
                'DELETE FROM %s WHERE deleted = 1',
                $tableName
            );
            $this->getDatabaseConnection()->sql_query($query);
        }
    }

    /**
     * @return void
     */
    protected function truncateCacheTables()
    {

        $this->outputLine('Truncating cache tables...');

        foreach ($this->getCacheTables() as $cacheTable) {
            $command = sprintf(
                '%s -u %s -p%s -e "TRUNCATE table %s;" %s',
                $this->getMysqlBinary(),
                $this->getUsername(),
                $this->getPassword(),
                $cacheTable,
                $this->getDatabase()
            );
            exec($command);
        }
    }

    /**
     * Returns the cache tables.
     *
     * @return array
     */
    protected function getCacheTables()
    {

        $cacheTables = array(
            #'be_sessions',
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

            if (!empty($result[1]) && $result[1] !== 'NULL') {
                $cacheTables = array_merge($cacheTables, explode(',', $result[1]));
            }

        }
        return $cacheTables;
    }

    /**
     * @return string
     */
    protected function getDatabase()
    {
        return $GLOBALS['TYPO3_CONF_VARS']['DB']['database'];
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $GLOBALS['TYPO3_CONF_VARS']['DB']['username'];
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $GLOBALS['TYPO3_CONF_VARS']['DB']['password'];
    }

    /**
     * @return string
     */
    public function getMysqlBinary()
    {
        return 'mysql';
    }

    /**
     * Returns a pointer to the database.
     *
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
