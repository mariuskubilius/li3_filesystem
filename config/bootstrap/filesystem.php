<?php

/**
 * Lithium Filesystem: managing file uploads the easy way
 *
 * @copyright     Copyright 2012, Little Boy Genius (http://www.littleboygenius.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use li3_filesystem\storage\FileSystem;
use lithium\core\Libraries;

FileSystem::config(array(
	'default' => array(
		'adapter' => 'File',
			'strategies' => array(
				'FileUpload' => array(
					'allowed' => array('png', 'jpg')
			)
		),
		'path' => Libraries::get(true, 'path') . '/webroot/img'
	)
));

?>