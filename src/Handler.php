<?php
namespace Dalnix\Base;

use Dotenv\Dotenv;
use Env;

class Handler{

	public function __construct($argv, $neededParameters = null,$config = [], $loader = null){

		$this->filename = array_shift($argv);
		$this->commands = [];
		$this->commandsFullNameSpacedPath = $loader->getClassMap();
		$this->output = '';
		if(count($config)) {
			try {
				//make sure environment variables are read from correct config file
				$dotenv = new Dotenv($config[0], $config[1]);
				$dotenv->load();
				$dotenv->required($neededParameters);
			} catch (\Exception $e) {
			}
		}

		//expose all environment variables to the env() function
		Env::init();



		//if no command is issued for the tool, run help
		if(!$this->baseCommand = array_shift($argv)){
			$this->baseCommand = 'help';
		}

		//load all available commands
		$this->loadCommands();

		//check if the command we want to run actually exists.
		if(array_key_exists($this->baseCommand,$this->commands)){
			//This is the command we want to run

			//run the command
			$this->cmd = new $this->commands[$this->baseCommand]($argv);
			$data = call_user_func([$this->cmd, count($argv) ? $argv[0] : 'main'], $argv);
			if($data) {
				//if the command returned any data, use that
				$this->output .= $data;
			}
			else{
				//if the command did not return any data - (false or null) see if there is a helper function for the subcommand.
				if(method_exists($this->cmd, count($argv) ? $argv[0].'Help' : false )) {
					$this->output .= call_user_func( [ $this->cmd, $argv[0].'Help'] );
				}
				else{
					//and if not - run help. :)
					$this->help();
				}
			}

		}
		else{
			//if no command is issued - run help.
			$this->help();
		}


	}
	public function run(){
		echo $this->output.PHP_EOL;
	}

	public function loadCommands(){

		foreach($this->commandsFullNameSpacedPath as $nameSpacedCommand=>$file){
			$command = getCommandNameFromFileName($file);
			$this->commands[$command] = $nameSpacedCommand;
		}

	}


	public function help(){
		$this->output.=$this->filename.":".PHP_EOL;
		$this->cmd = new helpCommand($this->commands, $this->filename);
		$this->output.= $this->cmd->main();
	}
}