<?php

class Imager {

	private $allowed = ['jpg','png','jpeg'];  

	private $disk = ""; 
	
	protected $path = "/public/uploads";

	public function __construct($files = null){
		$this->files = $files;
		$dir = dirname(__DIR__, 1);
		$this->disk = $dir.$this->path;
	}

	public function save(){
		
		$uri = [];
		if(empty(array_filter($this->files))) return "No files available";
		foreach($this->files["name"] as $key=>$val){
			$ext = substr(strrchr($this->files["name"][$key], '.'), 1); 

			$name = md5(uniqid(rand(), true));
			$target = "$this->disk/$name.$ext";

			//if(in_array($ext,$this->allowed)) continue;
	
			if(move_uploaded_file($this->files["tmp_name"][$key], $target)) $uri[] = "$this->path/$name.$ext";
		}

		return $uri;

	}

	public function delete($file){
		if(file_exists(dirname(__DIR__, 1).$file)) unlink(dirname(__DIR__, 1).$file);	
	}

}
