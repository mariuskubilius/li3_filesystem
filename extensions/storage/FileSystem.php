<?php

namespace li3_filesystem\extensions\storage;

/**
 * Lithium Filesystem: managing file uploads the easy way
 *
 * @copyright     Copyright 2012, Little Boy Genius (http://www.littleboygenius.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

/**
 * The `FileSystem` static class provides a consistent interface to configure and utilize the different
 * file handling adatpers included, as well as your own adapters.
 *
 * In most cases, you will configure various named Filesystem configurations in your bootstrap process,
 * which will then be available to you in all other parts of your application.
 *
 * A simple example configuration:
 *
 * {{{Filesystem::config(array(
 *     'db' => array('adapter' => 'FS.Grid'),
 *     'cdn' => array(
 *         'adapter' => 'CloudFiles',
 *         'api' =>'enter your api key here blah blah',
 *     ),
 *     'default' => array(
 * 			'adapter' => 'File',
 * 			'upload_dir' => 'uploads\',
 * 		)
 * ));}}}
 *
 * @see lithium\core\Adaptable
 * @see app\extensions\storage\filesystem\adapter
 */

class FileSystem extends \lithium\core\Adaptable {

	/**
	 * Stores configurations for FileSystem adapters
	 *
	 * @var array
	 */
	protected static $_configurations = array();

	/**
	 * Libraries::locate() compatible path to adapters for this class.
	 *
	 * @var string Dot-delimited path.
	 */
	protected static $_adapters = 'adapter.storage.filesystem';

	/**
	 * Libraries::locate() compatible path to strategies for this class.
	 *
	 * @var string Dot-delimited path.
	 */
	protected static $_strategies = 'strategy.storage.filesystem';

	/**
	 * Writes file from tmp to the specified filesystem configuration.
	 *
	 * @param string $name Configuration to be used for writing
	 * @param string $filename a full path with filename and extension to be written
	 * @param mixed $data usualy an output of file field
	 * @param mixed $options Options for the method, filters and strategies.
	 * @return boolean True on successful FileSystem write, false otherwise
	 * @filter This method may be filtered.
	 * @TODO implement configurations
	 */
	public static function write($name, $filename, $data, array $options = array()) {
		$options += array('strategies' => true);
		$settings = static::config();

		if (!isset($settings[$name])) {
			return false;
		}

		if ($options['strategies']) {
			$options = array('filename' => $filename);
			$data = static::applyStrategies(__FUNCTION__, $name, $data, $options);
		}

		if (!$data) {
			return false;
		}

		$method = static::adapter($name)->write($filename, $data, $options);
		$params = compact('filename', 'data');
		return static::_filter(__FUNCTION__, $params, $method, $settings[$name]['filters']);
	}

	/**
	 * Reads file from the specified filesystem configuration
	 *
	 * @param string $name Configuration to be used for reading
	 * @param mixed $filename a full path with filename and extension to be retrieved
	 * @param mixed $options Options for the method and strategies.
	 * @return mixed Read results on successful filesystem read, null otherwise
	 * @filter This method may be filtered.
	 */
	public static function read($name, $filename, array $options = array()) {
		$settings = static::config();

		if (!isset($settings[$name])) {
			return false;
		}

		$method = static::adapter($name)->read($filename, $options);
		$params = compact('filename');
		return static::_filter(__FUNCTION__, $params, $method, $settings[$name]['filters']);
	}

	/**
	 * Deletes file from the specified filesystem configuration
	 *
	 * @param string $name Configuration to be used for deletion
	 * @param mixed $filename a full path with filename and extension to be deleted
	 * @param mixed $options Options for the method and strategies.
	 * @return boolean True on successful deletion, false otherwise
	 * @filter This method may be filtered.
	 */
	public static function delete($name, $filename, array $options = array()) {
		$settings = static::config();

		if (!isset($settings[$name])) {
			return false;
		}

		$method   = static::adapter($name)->delete($filename);
		$params   = compact('filename');
		return static::_filter(__FUNCTION__, $params, $method, $settings[$name]['filters']);
	}

	/**
	 * Checks if the file from the specified filesystem configuration exists
	 *
	 * @param string $name Configuration to be used for deletion
	 * @param mixed $filename a full path with filename and extension to be checked
	 * @param mixed $options Options for the method and strategies.
	 * @return boolean True on successful check, false otherwise
	 * @filter This method may be filtered.
	 */
	public static function exists($name, $filename, array $options = array()) {
		$settings = static::config();

		if (!isset($settings[$name])) {
			return false;
		}

		$method   = static::adapter($name)->exists($filename);
		$params   = compact('filename');
		return static::_filter(__FUNCTION__, $params, $method, $settings[$name]['filters']);
	}

}

?>