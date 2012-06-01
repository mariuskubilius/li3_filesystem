<?php

namespace li3_filesystem\tests\cases\extensions\adapter\storage\filesystem;

/**
 * Lithium Filesystem: managing file uploads the easy way
 *
 * @copyright     Copyright 2012, Little Boy Genius (http://www.littleboygenius.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use SplFileInfo;
use li3_filesystem\extensions\adapter\storage\filesystem\File;

class FileTest extends \lithium\test\Unit {

	protected $configuration = array(
		'path' => '/tmp'
	);

	/**
	 * Skip the test if the default File adapter read/write path is not read/write-able.
	 *
	 * @return void
	 */
	public function skip() {
		$directory  = new SplFileInfo($this->configuration['path']);
		$accessible = ($directory->isDir() && $directory->isReadable() && $directory->isWritable());
		$message    = 'The File filesystem adapter path does not have the proper permissions.';
		$this->skipIf(!$accessible, $message);
	}

	public function setUp() {
		$this->file = new File($this->configuration);
	}

	public function tearDown() {
		if (file_exists($this->configuration['path'] . '/test_file')) {
			unlink($this->configuration['path'] . '/test_file');
		}
		unset($this->file);
	}

	public function testSimpleWrite() {
		$filename = 'test_file';
		$data = 'data';

		$closure = $this->file->write($filename, $data);
		$this->assertTrue(is_callable($closure));

		$params = compact('filename', 'data');
		$result = $closure($this->file, $params, null);
		$this->assertTrue($result);

		$result = file_get_contents($this->configuration['path'] . '/' . $filename);
		$this->assertEqual($data, $result);
	}

	public function testReadNonexistentFile() {
		$filename = 'thisfileshouldnotexist_file';

		$closure = $this->file->read($filename);
		$this->assertTrue(is_callable($closure));

		$params = compact('filename');
		$result = $closure($this->file, $params, null);
		$this->assertFalse($result);
	}

		public function testReadEmptyFile() {
		$filename = 'test_file';
		$data     = '';

		file_put_contents($this->configuration['path'] . '/' . $filename, $data);

		$closure = $this->file->read($filename);
		$this->assertTrue(is_callable($closure));

		$params = compact('filename');
		$result = $closure($this->file, $params);
		$this->assertEqual($data, $result);
	}

	public function testReadExistingFile() {
		$filename = 'test_file';
		$data     = 'Some test content';

		file_put_contents($this->configuration['path'] . '/' . $filename, $data);

		$closure = $this->file->read($filename);
		$this->assertTrue(is_callable($closure));

		$params = compact('filename');
		$result = $closure($this->file, $params);
		$this->assertEqual($data, $result);
	}

	public function testDeleteNonexistentFile() {
		$filename = 'no_file';

		$closure = $this->file->delete($filename);
		$this->assertTrue(is_callable($closure));

		$params = compact('filename');
		$result = $closure($this->file, $params);
		$this->assertFalse($result);
	}

	public function testDeleteExistingFile() {
		$filename = 'test_file';
		$data = 'Some content';

		file_put_contents($this->configuration['path'] . '/' . $filename, $data);

		$closure = $this->file->delete($filename);
		$this->assertTrue(is_callable($closure));

		$params = compact('filename');
		$this->assertTrue(file_exists($this->configuration['path'] . '/' . $filename));

		$result = $closure($this->file, $params);
		$this->assertFalse(file_exists($this->configuration['path'] . '/' . $filename));
	}
}

?>