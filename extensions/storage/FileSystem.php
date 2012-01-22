<?php
/**
 * Lithium Filesystem: managing file uploads the easy way
 *
 * @copyright     Copyright 2012, Little Boy Genius (http://www.littleboygenius.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_filesystem\extensions\storage;

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
	protected static $_adapters = 'storage.filesystem.adapter';

	/**
	 * Writes file from tmp to the specified filesystem configuration.
	 *
	 * @param string $name Configuration to be used for writing
	 * @param string $filePath a full path with filename and extension to be written
	 * @param mixed $data usualy an output of file field
	 * @param mixed $options Options for the method, filters and strategies.
	 * @return boolean True on successful FileSystem write, false otherwise
	 * @filter This method may be filtered.
	 * @TODO implement configurations
	 */
	public static function write($name, $filePath, $data, array $options = array()) {
        $settings = static::config();

        $method = static::adapter($name)->write($key, $data, $options);
        $params = compact('filePath', 'data');
        return static::_filter(__FUNCTION__, $params, $method, $settings[$name]['filters']);
	}

	/**
	 * Reads file from the specified filesystem configuration
	 *
	 * @param string $name Configuration to be used for reading
	 * @param mixed $filePath a full path with filename and extension to be retrieved
	 * @param mixed $options Options for the method and strategies.
	 * @return mixed Read results on successful filesystem read, null otherwise
	 * @filter This method may be filtered.
	 * @TODO implement
	 */
	public static function read($name, $filePath, array $options = array()) {
	}

	/**
	 * Deletes file from the specified filesystem configuration
	 *
	 * @param string $name Configuration to be used for deletion
	 * @param mixed $filePath a full path with filename and extension to be deleted
	 * @param mixed $options Options for the method and strategies.
	 * @return boolean True on successful deletion, false otherwise
	 * @filter This method may be filtered.
	 * @TODO implement
	 */
	public static function delete($name, $filePath, array $options = array()) {

	}
}
?>
