Speciality Distribution
=======================

Speciality Distribution for TYPO3 CMS.

Please, refer to https://github.com/Ecodev/typo3-cms-speciality-distribution


Generate SQL export
===================

There is a convenience command for generating a SQL dump ready for the import::

	# Export database and create a SQL dump file at EXT:speciality_distribution/ext_tables_static+adt.sql
	./typo3/cli_dispatch.phpsh extbase distribution:export
