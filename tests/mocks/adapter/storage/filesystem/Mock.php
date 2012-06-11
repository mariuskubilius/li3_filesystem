<?php

namespace li3_filesystem\tests\mocks\adapter\storage\filesystem;

/**
 * Lithium Filesystem: managing file uploads the easy way
 *
 * @copyright     Copyright 2012, Little Boy Genius (http://www.littleboygenius.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use lithium\core\Libraries;

class Mock extends \lithium\core\Object {

	public static $storage = array();

	public function __construct(array $config = array()) {
		$defaults = array(
			'path' => Libraries::get(true, 'path') . '/webroot/uploads'
		);
		parent::__construct($config + $defaults);
	}

	public function write($filename, $data, array $options = array()) {
		$path = $this->_config['path'];
		$storage =& static::$storage;

		return function($self, $params) use (&$path, &$storage) {
			$data = $params['data'];
			$path = "{$path}/{$params['filename']}";

			$storage[$path] = $data;
			return $params['filename'];
		};
	}

	public function read($filename) {
		$path = $this->_config['path'];
		$storage =& static::$storage;

		return function($self, $params) use (&$path, &$storage) {
			$path = "{$path}/{$params['filename']}";

			if (isset($storage[$path])) {
				return $storage[$path];
			}

			return false;
		};
	}

	public function delete($filename) {
		$path = $this->_config['path'];
		$storage =& static::$storage;

		return function($self, $params) use (&$path, &$storage) {
			$path = "{$path}/{$params['filename']}";

			if (isset($storage[$path])) {
				unset($storage[$path]);
				return true;
			}

			return false;
		};
	}

	public function exists($filename) {
		$path = $this->_config['path'];
		$storage =& static::$storage;

		return function($self, $params) use (&$path, &$storage) {
			$path = "{$path}/{$params['filename']}";

			return isset($storage[$path]);
		};
	}


}



?>