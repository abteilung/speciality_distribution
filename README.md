Speciality Distribution
=======================

Speciality Distribution for TYPO3 CMS.

Please, refer to https://github.com/Ecodev/typo3-cms-speciality-distribution

Generate SQL export
===================

There is a utility command for generating a SQL dump ready for the import. 
The command will generate a SQL dump file in EXT:speciality_distribution/ext_tables_static+adt.sql:

```

	# Replace "./typo3cms" by "./typo3/cli_dispatch.phpsh extbase distribution:export" if typo3_console is not installed
	./typo3cms distribution:export
```
