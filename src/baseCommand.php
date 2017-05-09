<?php
namespace Dalnix\Base;

class baseCommand{

	public function __construct($args = null, $filename = null) {
		if($args) {
			$this->args = $args;
		}
		if($filename){
			$this->filename = $filename;
		}

	}

	public function __call($name, $arguments){

		if(method_exists($this, $name.'SubCommand')){
			return call_user_func([$this,$name.'SubCommand'], $arguments);
		}
		else{
			return $this->main($arguments);
		}
	}

	public function main($args = null){
		return 'You need to create the function main($args = null) in your command.';
	}

	public function help(){
		return "";
	}


	public function shell_exec($cmd){
		return shell_exec($cmd .' 2>/dev/null');
	}

	public function exec_hidden($cmd){
		return exec($cmd .' > /dev/null &');
	}

}