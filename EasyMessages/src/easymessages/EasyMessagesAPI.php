<?php

namespace easymessages;

use easymessages\command\EasyMessagesCommand;
use easymessages\event\EasyMessagesListener;
use easymessages\task\AutoMessageTask;
use easymessages\task\AutoPopupTask;
use easymessages\task\AutoTipTask;
use easymessages\task\BlinkingPopupTask;
use easymessages\task\BlinkingTipTask;
use easymessages\task\InfinitePopupTask;
use easymessages\task\InfiniteTipTask;
use easymessages\task\ScrollingPopupTask;
use easymessages\task\ScrollingTipTask;
use easymessages\task\UpdateMotdTask;
use pocketmine\plugin\PluginBase;

class EasyMessagesAPI extends PluginBase{
    private $easymessages;
    public function onEnable(){
        $this->saveFiles();
        $this->registerAll();
        $this->getServer()->getLogger()->info("§aEnabling ".$this->getDescription()->getFullName()."...");
    }
    public function onDisable(){
	$this->getServer()->getLogger()->info("§cDisabling ".$this->getDescription()->getFullName()."...");
    }
    private function saveFiles(){
        if(!file_exists($this->getDataFolder())){
            mkdir($this->getDataFolder());
        }
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
        if(!file_exists($this->getDataFolder()."values.txt")){
            $this->saveResource("values.txt");
        }
    }
    private function registerAll(){
    	$this->easymessages = array();
    	$this->getServer()->getCommandMap()->register("easymessages", new EasyMessagesCommand($this));
    	if($this->getConfig()->getNested("message.autoBroadcast") === true){
    	    $this->getServer()->getScheduler()->scheduleRepeatingTask(new AutoMessageTask($this), ($this->getConfig()->getNested("message.interval") * 20));
    	}
    	if(strtolower($this->getConfig()->getNested("popup.displayType")) === "auto"){
    	    $this->getServer()->getScheduler()->scheduleRepeatingTask(new AutoPopupTask($this), ($this->getConfig()->getNested("popup.interval") * 20));
    	}
    	if(strtolower($this->getConfig()->getNested("tip.displayType")) === "auto"){
    	    $this->getServer()->getScheduler()->scheduleRepeatingTask(new AutoTipTask($this), ($this->getConfig()->getNested("tip.interval") * 20));
    	}
    	if(strtolower($this->getConfig()->getNested("popup.displayType")) === "blinking"){
	    $this->getServer()->getScheduler()->scheduleRepeatingTask(new BlinkingPopupTask($this), 30);
    	}
    	if(strtolower($this->getConfig()->getNested("tip.displayType")) === "blinking"){
	    $this->getServer()->getScheduler()->scheduleRepeatingTask(new BlinkingTipTask($this), 30);	
    	}
    	if(strtolower($this->getConfig()->getNested("popup.displayType")) === "infinite"){
	    $this->getServer()->getScheduler()->scheduleRepeatingTask(new InfinitePopupTask($this), 7);
    	}
    	if(strtolower($this->getConfig()->getNested("tip.displayType")) === "infinite"){
	    $this->getServer()->getScheduler()->scheduleRepeatingTask(new InfiniteTipTask($this), 7);	
    	}
    	if(strtolower($this->getConfig()->getNested("motd.displayType")) === "dynamic"){
    	    $this->getServer()->getScheduler()->scheduleRepeatingTask(new UpdateMotdTask($this), ($this->getConfig()->getNested("motd.interval") * 20));
    	}
    	else{
    	    $this->setMotd($this->getConfig()->getNested("motd.staticMotd"));
    	}
    	$this->getServer()->getPluginManager()->registerEvents(new EasyMessagesListener($this), $this);
    }
    public function broadcastPopup($message){
        foreach($this->getServer()->getOnlinePlayers() as $player){
            $player->sendPopup($message);
        }
    }
    public function broadcastTip($message){
    	foreach($this->getServer()->getOnlinePlayers() as $player){
    	    $player->sendTip($message);
    	}
    }
    public function drawRandomMessage(array $messages, $amount = 1){
    	return $messages[array_rand($messages, $amount)];
    }
    public function setMotd($name = ""){
    	$this->getServer()->getNetwork()->setName($name);
    }
    public function replaceSymbols($message, $revert = false){
    	$defaultColors = array(
    	    "§0",
    	    "§1",
    	    "§2",
    	    "§3",
    	    "§4",
    	    "§5",
    	    "§6",
    	    "§7",
    	    "§8",
    	    "§9",
    	    "§a",
    	    "§b",
    	    "§c",
    	    "§d",
    	    "§e",
    	    "§f",
    	    "§k",
    	    "§l",
    	    "§m",
    	    "§n",
    	    "§o",
    	    "§r"
    	);
    	$replaceColors = array(
    	    "&0",
    	    "&1",
    	    "&2",
    	    "&3",
    	    "&4",
    	    "&5",
    	    "&6",
    	    "&7",
    	    "&8",
    	    "&9",
    	    "&a",
    	    "&b",
    	    "&c",
    	    "&d",
    	    "&e",
    	    "&f",
    	    "&k",
    	    "&l",
    	    "&m",
    	    "&n",
    	    "&o",
    	    "&r"
    	);
    	if($revert === true){
    	    return str_replace($defaultColors, "", $message);
    	}
    	else{
    	    return str_replace($replaceColors, $defaultColors, $message);
    	}
    }
}
