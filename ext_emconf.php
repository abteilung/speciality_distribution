<?php
$EM_CONF[$_EXTKEY] = [
	'title' => 'Speciality Distribution',
	'description' => 'Delivers a special website just for you. This distribution can be installed via Composer with command ``composer create-project ecodev/typo3-cms-speciality-distribution htdocs dev-master``',
	'category' => 'distribution',
	'state' => 'stable',
	'author' => 'Fabien Udriot',
	'author_email' => 'fabien@ecodev.ch',
	'author_company' => 'Ecodev',
	'version' => '1.3.0-dev',
	'constraints' =>
	[
		'depends' =>
		[
			'typo3' => '7.6.0-8.99.99',
			'speciality' => '',
			'scheduler' => '',
			'realurl' => '',
			'vidi' => '',
			'vidi_frontend' => '',
			'media' => '',
			'typo3_console' => '',
		],
		'conflicts' =>
		[
			'css_styled_content' => '',
		],
		'suggests' =>
		[
		],
	],
];
