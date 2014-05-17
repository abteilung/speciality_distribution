Speciality Distribution
=======================

Speciality Distribution for TYPO3 CMS.

Motivation
----------

All started with the modernisation of our Dummy package we were using in our company
and we  **have put everything in public** so that you can test and also take advantage for your own needs...

For more detail see https://github.com/Ecodev/bootstrap_package

How to install?
===============

- Install TYPO3, download the current stable Core http://get.typo3.org/current.
- You will be guided until the list of distributions, just pick Speciality Distribution.

Generate SQL export
===================

There is a convenience command for generating a SQL dump ready for the import::

	# Export database and create a SQL dump file at EXT:speciality_distribution/ext_tables_static+adt.sql
	./typo3/cli_dispatch.phpsh extbase distribution:export
