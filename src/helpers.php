<?php
namespace Dalnix\Base;

function getCommandNameFromFileName($filename){

	$command = explode('/',$filename);
	$command = array_pop($command);
	$command = explode('.', $command)[0];
	$command = str_replace('Command','', $command);
	return $command;
}

