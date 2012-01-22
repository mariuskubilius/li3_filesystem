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
    protected $_testDirectory = '/tmp';

    /**
	 * Skip the test if the default File adapter read/write path is not read/write-able.
	 *
	 * @return void
	 */
	public function skip() {
		$directory = new SplFileInfo($this->_testDirectory);
		$accessible = ($directory->isDir() && $directory->isReadable() && $directory->isWritable());
		$message = 'The File filesystem adapter path does not have the proper permissions.';
		$this->skipIf(!$accessible, $message);
	}

	public function setUp() {
		$this->file = new File();
	}

	public function tearDown() {
		if(file_exists($this->_testDirectory . '/test_file')) {
            unlink($this->_testDirectory . '/test_file');
		}
		unset($this->file);
	}

	public function testCreateEmptyFile() {
	    $path = $this->_testDirectory . '/test_file';
        $this->file->write($path);
	}

	public function testCreateFileWithContent() {
        $path = $this->_testDirectory . '/test_file';
        $data = 'Some content';

        $this->file->write($path, $data);

        $this->assertTrue(file_exists($path));
        $this->assertEqual($data, file_get_contents($path));
	}

	public function testReadFile() {

	}

	public function testDeleteFile() {

	}
}
?>
