<?php

namespace locatorpro;

use locatorpro\command\LocatorProCommand;
use locatorpro\event\LocatorProListener;
use pocketmine\level\Location;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Player;

class LocatorPro extends PluginBase{
    private $locations;
    public function onEnable(){
    	$this->saveFiles();
        $this->registerAll();
        $this->getServer()->getLogger()->info("§aEnabling ".$this->getDescription()->getFullName()."...");
    }
    public function onDisable(){
        $this->getServer()->getLogger()->info("§cDisabling ".$this->getDescription()->getFullName()."...");
    }
    private function saveFiles(){
    	if(!is_dir($this->getDataFolder())){
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
        $this->locations = new Config($this->getDataFolder()."locations.yml", Config::YAML);
    }
    private function registerAll(){
    	$this->getServer()->getCommandMap()->register("locatorpro", new LocatorProCommand($this));
    	$this->getServer()->getPluginManager()->registerEvents(new LocatorProListener($this), $this);
    }
    public function locationExists(Player $player, $key){
    	return array_key_exists(); //To-do
    }
    public function getSavedPlayerLocation(Player $player, $key){
        return $this->locations->getNested(strtolower($player->getName()).strtolower($key));
    }
    public function savePlayerLocation(Player $player, $key){
        $this->locations->setNested(strtolower($player->getName()).strtolower($key), array(
            0 => round($player->getX(), $this->getConfig()->getNested("integer.roundPrecision")),
            1 => round($player->getX(), $this->getConfig()->getNested("integer.roundPrecision")),
            2 => round($player->getX(), $this->getConfig()->getNested("integer.roundPrecision")),
            3 => round($player->getYaw(), $this->getConfig()->getNested("integer.roundPrecision")),
            4 => round($player->getPitch(), $this->getConfig()->getNested("integer.roundPrecision")),
            5 => $player->getLevel()->getName()
        ));
        $this->getSavedLocations()->save();
    }
    public function teleportPlayerToSavedLocation(Player $player, $key){
        $player->teleport(new Location(
            $this->getSavedPlayerLocation($player, strtolower($key))[0],
            $this->getSavedPlayerLocation($player, strtolower($key))[1],
            $this->getSavedPlayerLocation($player, strtolower($key))[2],
            $this->getSavedPlayerLocation($player, strtolower($key))[3],
            $this->getSavedPlayerLocation($player, strtolower($key))[4],
            $this->getSavedPlayerLocation($player, strtolower($key))[5]
        ));
    }
}
