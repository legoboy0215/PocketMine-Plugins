<?php

namespace restartme\task;

use pocketmine\scheduler\PluginTask;
use restartme\RestartMe;

class RestartServerTask extends PluginTask{
    public function __construct(RestartMe $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onRun($currentTick){
        $time = $this->getPlugin()->restartme["restartTime"]--;
        if($time <= $this->getPlugin()->getConfig()->getNested("restart.startCountdown")){
            $this->getPlugin()->broadcastTime($this->getPlugin()->getConfig()->getNested("restart.displayType"));
        }
        if($time < 0){
            $this->getPlugin()->initiateRestart(0);
        }
    }
}
