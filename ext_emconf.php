<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "introduction".
 *
 * Auto generated 03-05-2014 17:29
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Speciality Distribution',
	'description' => 'Delivers a special website just for you. This distribution can be installed via Composer with command ``composer create-project ecodev/typo3-cms-speciality-distribution htdocs dev-master``',
	'category' => 'distribution',
	'state' => 'beta',
	'author' => 'Fabien Udriot',
	'author_email' => 'support@ecodev.ch',
	'author_company' => 'Ecodev',
	'version' => '1.3.0-dev',
	'constraints' =>
	array (
		'depends' =>
		array (
			'typo3' => '7.6.0-7.99.99',
			'vhs' => '',
			'speciality' => '',
			'realurl' => '',
			'vidi' => '',
			'media' => '',
			'scheduler' => '',
			'nc_staticfilecache' => '',
			'seo_basics' => '',
			'typo3_console' => '',
		),
		'conflicts' =>
		array (
		),
		'suggests' =>
		array (
		),
	),
);
