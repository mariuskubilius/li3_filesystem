<?php

namespace li3_filesystem\tests\integration\storage;

/**
 * Lithium Filesystem: managing file uploads the easy way
 *
 * @copyright     Copyright 2012, Little Boy Genius (http://www.littleboygenius.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use li3_filesystem\extensions\storage\FileSystem;

class FileSystemTest extends \lithium\test\Integration {

	public function setUp() {
		FileSystem::reset();
	}

	public function tearDown() {
		FileSystem::reset();
	}

	public function testBasicFileSystemConfig() {
		$result = FileSystem::config();
		$this->assertFalse($result);

		$config = array('default' => array('adapter' => '\some\adapter', 'filters' => array()));
		$result = FileSystem::config($config);
		$this->assertNull($result);

		$expected = $config;
		$result   = FileSystem::config();
		$this->assertEqual($expected, $result);

		$result = FileSystem::reset();
		$this->assertNull($result);

		$config = array('default' => array('adapter' => '\some\adapter', 'filters' => array()));
		FileSystem::config($config);

		$result   = FileSystem::config();
		$expected = $config;
		$this->assertEqual($expected, $result);

		$result = FileSystem::reset();
		$this->assertNull($result);

		$config = array('default' => array(
			'adapter' => '\some\adapter',
			'filters' => array('Filter1', 'Filter2')
		));
		FileSystem::config($config);

		$result   = FileSystem::config();
		$expected = $config;
		$this->assertEqual($expected, $result);
	}

	public function testFileSystemActions() {
		$config = array('default' => array(
			'adapter' => '\li3_filesystem\tests\mocks\adapter\storage\filesystem\Mock',
			'filters' => array(),
			'path'    => '/tmp'
		));
		FileSystem::config($config);

		$filename = 'test_file';
		$data     = 'Some test content';

		$this->assertFalse(FileSystem::exists('default', $filename));

		$this->assertTrue(FileSystem::write('default', $filename, $data));

		$this->assertTrue(FileSystem::exists('default', $filename));

		$result = FileSystem::read('default', $filename);
		$this->assertEqual($data, $result);

		$this->assertTrue(FileSystem::delete('default', $filename));
	}
}

?>