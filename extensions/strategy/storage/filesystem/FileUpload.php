<?php
namespace li3_filesystem\extensions\strategy\storage\filesystem;

class FileUpload extends \lithium\core\Object {
	
	public function read($data){
		return $data;	
	}
	
	public function write($data, array $options = array() ) {
		$allowed = $this->_config['allowed'];
		$file = pathinfo($data['name']);
		$filename = pathinfo($options['filename']);
		if($filename['extension']==$file['extension'] && in_array($file['extension'], $allowed)) {
			$data = file_get_contents($data['tmp_name']);
		}
		else {
			return false;
		}
		return $data;
	}
}
?>