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
        if($this->getPlugin()->getTimeRemaining() >= $this->getPlugin()->getConfig()->getNested("restart.startCountdown")){
            if(strtolower($this->getPlugin()->getConfig()->getNested("restart.displayType")) === "message"){
                $this->getPlugin()->getServer()->broadcastMessage(str_replace("{RESTART_TIME}", $this->getPlugin()->getTimeRemaining(), $this->getPlugin()->getConfig()->getNested("restart.countdownMessage")));
            }
            if(strtolower($this->getPlugin()->getConfig()->getNested("restart.displayType")) === "popup"){
                foreach($this->getPlugin()->getServer()->getOnlinePlayers() as $player){
                    $player->sendPopup(str_replace("{RESTART_TIME}", $this->getPlugin()->getTimeRemaining(), $this->getPlugin()->getConfig()->getNested("restart.countdownMessage")));
                }
            }
            if(strtolower($this->getPlugin()->getConfig()->getNested("restart.displayType")) === "tip"){
                foreach($this->getPlugin()->getServer()->getOnlinePlayers() as $player){
                    $player->sendTip(str_replace("{RESTART_TIME}", $this->getPlugin()->getTimeRemaining(), $this->getPlugin()->getConfig()->getNested("restart.countdownMessage")));
                }
            }
        }
        else{
            $this->getPlugin()->getServer()->getScheduler()->cancelTask($this->getTaskId());
        }
    }
}
