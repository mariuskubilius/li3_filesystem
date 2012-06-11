<?php

namespace li3_filesystem\tests\cases\extensions\storage\filesystem\adapter;

/**
 * Lithium Filesystem: managing file uploads the easy way
 *
 * @copyright     Copyright 2012, Little Boy Genius (http://www.littleboygenius.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use SplFileInfo;
use li3_filesystem\extensions\storage\filesystem\adapter\File;
use lithium\core\Libraries;

class FileTest extends \lithium\test\Unit {

	protected $_testDirectory = '/tmp';

	/**
	 * Skip the test if the default File adapter read/write path is not read/write-able.
	 *
	 * @return void
	 */
	public function skip() {
		$this->_testDirectory = Libraries::get(true, 'resources') . '/tmp/tests';

		$directory = new SplFileInfo($this->_testDirectory);
		$accessible = ($directory->isDir() && $directory->isReadable() && $directory->isWritable());
		$message = 'The File filesystem adapter path does not have the proper permissions.';
		$this->skipIf(!$accessible, $message);
	}

	public function setUp() {
		$this->file = new File();
	}

	public function tearDown() {
		if (file_exists($this->_testDirectory . '/test_file')) {
			unlink($this->_testDirectory . '/test_file');
		}
		unset($this->file);
	}

	public function testCreateEmptyFile() {
		$filename = $this->_testDirectory . '/test_file';
		$this->file->write($filename);
	}

	public function testCreateFileWithContent() {
		$filename = $this->_testDirectory . '/test_file';
		$data = 'Some content';

		$this->file->write($filename, $data);

		$this->assertTrue(file_exists($filename));
		$this->assertEqual($data, file_get_contents($filename));
	}

	public function testReadNonexistentFile() {
		$filename = '/path/to/no/file';
		$this->assertFalse($this->file->read($filename));
	}

	public function testReadEmptyFile() {
		$filename = $this->_testDirectory . '/test_file';
		$data     = '';

		file_put_contents($filename, $data);

		$results = $this->file->read($filename);
		$this->assertEqual($data, $results);
	}

	public function testReadExistingFile() {
		$filename = $this->_testDirectory . '/test_file';
		$data     = 'Some test content';

		file_put_contents($filename, $data);

		$results = $this->file->read($filename);
		$this->assertEqual($data, $results);
	}

	public function testDeleteNonexistentFile() {
		$filename = '/path/to/no/file';
		$this->assertFalse($this->file->delete($filename));
	}

	public function testDeleteExistingFile() {
		$filename = $this->_testDirectory . '/test_file';
		$data     = 'Some content';

		file_put_contents($filename, $data);

		$this->assertTrue(file_exists($filename));
		$this->file->delete($filename);
		$this->assertFalse(file_exists($filename));
	}
}

?>