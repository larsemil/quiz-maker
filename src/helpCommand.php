<?php
namespace Dalnix\Base;

class helpCommand extends baseCommand{

	public function main($args = null){
		$this->output = '';
		if(isset($this->args) && count($this->args)) {
			foreach ( $this->args as $command => $class ) {
				$cmd = new $class();
				if ( method_exists( $cmd, 'help' ) ) {
					$cmdHelp = call_user_func( [ $class, 'help' ] );
					if ( is_array( $cmdHelp ) ) {
						foreach ( $cmdHelp as $helpLine ) {
							$this->output .= $this->filename . " " . $helpLine . PHP_EOL;
						}
					} else {
						$this->output .= $this->filename . " " . $cmdHelp . PHP_EOL;
					}
				}
			}
		}

		return $this->output;
	}
}