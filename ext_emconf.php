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
	'state' => 'stable',
	'author' => 'Fabien Udriot',
	'author_email' => 'support@ecodev.ch',
	'author_company' => 'Ecodev',
	'version' => '1.2.6',
	'constraints' =>
	array (
		'depends' =>
		array (
			'typo3' => '7.6.0-7.99.99',
			'speciality' => '',
			'scheduler' => '',
			'realurl' => '',
			'vidi' => '',
			'media' => '',
			'seo_basics' => '',
			'typo3_console' => '',
			'nc_staticfilecache' => '',
		),
		'conflicts' =>
		array (
			'css_styled_content' => '',
		),
		'suggests' =>
		array (
		),
	),
);
