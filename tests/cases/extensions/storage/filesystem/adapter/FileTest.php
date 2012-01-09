<?php
/**
 * Lithium Filesystem: managing file uploads the easy way
 *
 * @copyright     Copyright 2012, Little Boy Genius (http://www.littleboygenius.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_filesystem\tests\cases\extensions\storage\filesystem\adapter;

use SplFileInfo;
use lithium\core\Libraries;
use li3_filesystem\extensions\storage\filesystem\adapter\File;

class FileTest extends \lithium\test\Unit {
	
	/**
	 * Checks whether the 'empty' file exists in `resources/tmp/cache` and, if so, ensures
	 * that it is restored at the end of the testing cycle.
	 *
	 * @var string
	 */
	protected $_hasEmpty = true;
	protected $_tempFile = NULL;
	/**
	 * Skip the test if the default File adapter read/write path
	 * is not read/write-able.
	 *
	 * @return void
	 */
	public function skip() {
		$directory = new SplFileInfo(Libraries::get(true, 'path').'/webroot/img');
		$accessible = ($directory->isDir() && $directory->isReadable() && $directory->isWritable());
		$message = 'The File filesystem adapter path does not have the proper permissions.';
		$this->skipIf(!$accessible, $message);
	}
	
	public function setUp() {
		$this->_hasEmpty = file_exists(Libraries::get(true, 'path') . "webroot/img/empty");
		$this->File = new File();
	}

	public function tearDown() {
		if ($this->_hasEmpty) {
			touch(Libraries::get(true, 'path') . "webroot/img/empty");
		}
		unset($this->File);
	}
	
	public function testEnabled() {
		$file = $this->File;
		$this->assertTrue($file::enabled());
	}
	/**
	public function testwhetherfileiscreated(){
		$this->_tempfile = tempnam(sys_get_temp_dir(), 'bluds');
		var_dump($this->_tempFile);
	}
	 */
}
?>