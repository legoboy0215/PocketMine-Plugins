<?php

namespace restartme;

use pocketmine\plugin\PluginBase;
use restartme\command\RestartMeCommand;
use restartme\task\AutoBroadcastTask;
use restartme\task\CheckMemoryTask;
use restartme\task\RestartServerTask;

class RestartMe extends PluginBase{
    public $restartme;
    public function onEnable(){
        $this->saveFiles();
        $this->registerAll();
        $this->getServer()->getLogger()->info("§aEnabling ".$this->getDescription()->getFullName()."...");
    }
    public function onDisable(){
        $this->getServer()->getLogger()->info("§cDisabling ".$this->getDescription()->getFullName()."...");
    }
    private function saveFiles(){
        if(file_exists($this->getDataFolder()."config.yml")){
            if($this->getConfig()->get("version") !== $this->getDescription()->getVersion() or !$this->getConfig()->exists("version")){
		$this->getServer()->getLogger()->warning("An invalid configuration file for ".$this->getDescription()->getName()." was detected.");
		if($this->getConfig()->getNested("plugin.autoUpdate") === true){
		    $this->saveResource("config.yml", true);
                    $this->getServer()->getLogger()->warning("Successfully updated the configuration file for ".$this->getDescription()->getName()." to v".$this->getDescription()->getVersion().".");
		}
	    }  
        }
        else{
            $this->saveDefaultConfig();
        }
    }
    private function registerAll(){
    	$this->restartme = array();
    	$this->restartme["restartTime"] = ($this->getConfig()->getNested("restart.restartInterval") * 60);
        $this->getServer()->getCommandMap()->register("restartme", new RestartMeCommand($this));
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new AutoBroadcastTask($this), ($this->getConfig()->getNested("restart.broadcastInterval") * 20));
        if($this->getConfig()->getNested("restart.restartOnOverload") === true){
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new CheckMemoryTask($this), 6000);
        }
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new RestartServerTask($this), 20);
    }
    public function getTimeRemaining(){
    	return $this->restartme["restartTime"];
    }
    public function setTimeRemaining($seconds){
    	$this->restartme["restartTime"] = $seconds;
    }
    public function addTime($seconds){
    	if(is_numeric($seconds)) $this->restartme["restartTime"] += $seconds;
    }
    public function subtractTime($seconds){
    	if(is_numeric($seconds)) $this->restartme["restartTime"] -= $seconds;
    }
    public function broadcastTime($messageType){
        $message = str_replace("{RESTART_TIME}", $this->getTimeRemaining(), $this->getConfig()->getNested("restart.countdownMessage"));
        switch(strtolower($messageType)){
            case "message":
                $this->getServer()->broadcastMessage($message);
                break;
            case "popup":
                foreach($this->getServer()->getOnlinePlayers() as $player){
                    $player->sendPopup($message);
                }
                break;
            case "tip":
                foreach($this->getServer()->getOnlinePlayers() as $player){
                    $player->sendTip($message);
                }
                break;
        }
    }
    public function initiateRestart($mode){
        switch($mode){
            case 0:
                foreach($this->getServer()->getOnlinePlayers() as $player){
                    $player->close("", $this->getConfig()->getNested("restart.quitMessage"));
                }
                break;
            case 1:
                foreach($this->getServer()->getOnlinePlayers() as $player){
                    $player->close("", $this->getConfig()->getNested("restart.overloadQuitMessage"));
                }
                break;
        }
        $this->getServer()->shutdown();
    }
}