<?php

namespace restartme\task;

use pocketmine\scheduler\PluginTask;
use restartme\RestartMe;

class CheckMemoryTask extends PluginTask{
    public function __construct(RestartMe $plugin){
	parent::__construct($plugin);
	$this->plugin = $plugin;
    }
    public function getPlugin(){
	return $this->plugin;
    }
    public function onRun($currentTick){
	if(memory_get_usage(true) > $this->getPlugin()->getConfig()->getNested("restart.memoryLimit")){
            $this->getPlugin()->initiateRestart(1);
	}
    }
}