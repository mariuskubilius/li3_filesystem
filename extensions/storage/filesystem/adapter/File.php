<?php
/**
 * Lithium Filesystem: managing file uploads the easy way
 *
 * @copyright     Copyright 2012, Little Boy Genius (http://www.littleboygenius.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_filesystem\extensions\storage\filesystem\adapter;

use lithium\util\Set;

/**
 * A File Filesystem adapter implementation. Requires
 * writable folder on filesystem for example webroot\uploads
 *
 * The `File` filesystem adapter is meant to be used through the `FileSystem` interface,
 * which abstracts away file writting, adapter instantiation and filter
 * implementation.
 *
 * A simple configuration of this adapter can be accomplished in `config/bootstrap/filesystem.php`
 * as follows:
 *
 * {{{
 * FileSystem::config(array(
 *     'filesystem-config-name' => array(
 *         'adapter' => 'Memcached',
 *         'upload_dir' => '\webroot\uploads'
 *     )
 * ));
 * }}}
 */

class File extends \lithium\core\Object {
	
	/**
	 * Class constructor.
	 *
	 * @see app\extensions\storage\FileSystem::config()
	 * @param array $config Configuration parameters for this filesystem adapter. These settings are
	 *        indexed by name and queryable through `FileSystem::config('name')`.
	 *        The defaults are:
	 *        - 'path' : Path where uploaded files live `LITHIUM_APP_PATH . '/webroot/uploads'`.
	 */
	public function __construct(array $config = array()) {
		
	}
	
	public function write() {
		
	}
	
	public function read() {
		
	}
	
	public function delete() {
		
	}
}
?>