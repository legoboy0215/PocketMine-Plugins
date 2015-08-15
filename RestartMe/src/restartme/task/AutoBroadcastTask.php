<?php

namespace restartme\task;

use pocketmine\scheduler\PluginTask;
use restartme\RestartMe;

class AutoBroadcastTask extends PluginTask{
    public function __construct(RestartMe $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onRun($currentTick){
        if($this->getPlugin()->getTimeRemaining() > $this->getPlugin()->getConfig()->getNested("restart.startCountdown")){
            $this->getPlugin()->broadcastTime($this->getPlugin()->getConfig()->getNested("restart.displayType"));
        }
    }
}