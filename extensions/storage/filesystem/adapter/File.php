<?php
/**
 * Lithium Filesystem: managing file uploads the easy way
 *
 * @copyright     Copyright 2012, Little Boy Genius (http://www.littleboygenius.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_filesystem\extensions\storage\filesystem\adapter;

use SplFileInfo;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use lithium\core\Libraries;

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
 *         'adapter' => 'File',
 *         'path' => '/webroot/img',
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
		$defaults = array(
			'path' => Libraries::get(true, 'path') . 'webroot/img/',
		);
		parent::__construct($config + $defaults);
	}

    /**
     * @param string $filename
     * @param string $data
     * @param array $options
     * @return boolean
     */
	public function write($filename, $data = null, array $options = array()) {
	  return (file_put_contents($filename, $data) ? true : false);
	}

    /**
     * @param string $filename
     * @return string|boolean
     */
	public function read($filename) {
	    if(file_exists($filename)) {
            return file_get_contents($filename);
	    }

	    return false;
	}

    /**
     * @param string $filename
     * @return boolean
     */
	public function delete($filename) {
	    if(file_exists($filename)) {
            return unlink($filename);
	    }

        return false;
	}
}
?>
