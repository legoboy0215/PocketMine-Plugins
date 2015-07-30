<?php

namespace imanager;

use imanager\command\iManagerCommand;
use imanager\event\iManagerListener;
use pocketmine\command\CommandSender;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\Server;

class iManagerAPI extends PluginBase{
    private $exempts;
    private $ip;
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
    	$this->exempts = new Config($this->getDataFolder()."exempts.txt", Config::ENUM);
    	$this->ip = new Config($this->getDataFolder()."ip.txt", Config::ENUM);
    }
    private function registerAll(){
    	$this->getServer()->getCommandMap()->register("imanager", new iManagerCommand($this));
    	$this->getServer()->getPluginManager()->registerEvents(new iManagerListener($this), $this);
    }
    public function isAddressWhitelisted($address){
    	return $this->ip->exists($address, true);
    }
    public function setAddressWhitelist(Player $player, $value = true){
    	if($value === true){
    	    $this->exempts->set(strtolower($player->getName()));
    	}
    	else{
    	    $this->exempts->remove(strtolower($player->getName()));
    	    $this->exempts->save();
    	}
    }
    public function isExempted(Player $player){
    	return $this->exempts->exists($player->getName(), true);
    }
    public function setExempt(Player $player, $value = true){
	if($value === true){
	    $this->exempts->set(strtolower($player->getName()));
	    $this->exempts->save();
	}
	else{
	    $this->exempts->remove(strtolower($player->getName()));
	    $this->exempts->save();
	}
    }
    public function getLevelInformation(CommandSender $sender, Level $level){
    	$sender->sendMessage("§bLevel information:");
    	$sender->sendMessage("Name: §b".$level->getName());
    	$sender->sendMessage("Entities: ".count($level->getEntities()));
    	$sender->sendMessage("Players: ".count($level->getPlayers()));
    	$sender->sendMessage("Tiles: ".count($level->getTiles()));
    	$sender->sendMessage("Chunks: ".count($level->getChunks()));
    	$sender->sendMessage("Spawn: ".$level->getSpawn());
    	$sender->sendMessage("Time: ".$level->getTime());
    	$sender->sendMessage("Seed: ".$level->getSeed());
    	$sender->sendMessage("Is-generated: ".($level->getServer()->isGenerated($level->getName()) ? "§ayes" : "§ano"));
    	$sender->sendMessage("Is-loaded: ".($level->getServer()->isLoaded($level->getName()) ? "§ayes" : "§ano"));
    }
    public function getPlayerInformation(CommandSender $sender, Player $player){
    	$sender->sendMessage("§bPlayer information:");
    	$sender->sendMessage("Name: §b".$player->getName());
    	$sender->sendMessage("Display-name: §b".$player->getDisplayName());
    	$sender->sendMessage("Name-tag: §b".$player->getNameTag());
    	$sender->sendMessage("Address: §c".$player->getAddress()."§f:§a".$player->getPort());
	$sender->sendMessage("Client-ID: ".$player->getClientId());
	$sender->sendMessage("Entity-ID: ".$player->getId());
    	$sender->sendMessage("Unique-ID: ".$player->getUniqueId());
    	$sender->sendMessage("Health: §c".$player->getHealth()."§f/§a".$player->getMaxHealth());
    	$sender->sendMessage("X: §c".$player->getFloorX());
    	$sender->sendMessage("Y: §9".$player->getFloorY());
    	$sender->sendMessage("Z: §a".$player->getFloorZ());
    	$sender->sendMessage("Level: §d".$player->getLevel()->getName());
    	$sender->sendMessage("Yaw: §6".$player->getYaw());
    	$sender->sendMessage("Pitch: §6".$player->getPitch());
    	$sender->sendMessage("Gamemode: §c".$player->getGamemode());
    	$sender->sendMessage("Held-item: §9".$player->getInventory()->getItemInHand()->getName());
    	$sender->sendMessage("Head-item: §9".$player->getInventory()->getArmorItem(0)->getName());
    	$sender->sendMessage("Chest-item: §9".$player->getInventory()->getArmorItem(1)->getName());
    	$sender->sendMessage("Leg-item: §9".$player->getInventory()->getArmorItem(2)->getName());
    	$sender->sendMessage("Feet-item: §9".$player->getInventory()->getArmorItem(3)->getName());
    	$sender->sendMessage("Sleeping: ".($player->isSleeping() ? "§ayes" : "§cno"));
    	$sender->sendMessage("Inside-water: ".($player->isInsideOfWater() ? "§ayes" : "§cno"));
    	$sender->sendMessage("Inside-solid: ".($player->isInsideOfSolid() ? "§ayes" : "§cno"));
    	$sender->sendMessage("On-ground: ".($player->isOnGround() ? "§ayes" : "§cno"));
    	$sender->sendMessage("On-fire: ".($player->isOnFire() ? "§ayes" : "§cno"));
    	$sender->sendMessage("Skin-slim: ".($player->isSkinSlim() ? "§ayes" : "§cno"));
    	$sender->sendMessage("Nametag-visible: ".($player->isNameTagVisible() ? "§ayes" : "§cno"));
    	$sender->sendMessage("Online: ".($player->isOnline() ? "§ayes" : "§cno"));
    	$sender->sendMessage("Connected: ".($player->isConnected() ? "§ayes" : "§cno"));
    	$sender->sendMessage("Valid: ".($player->isValid() ? "§ayes" : "§cno"));
    	$sender->sendMessage("Alive: ".($player->isAlive() ? "§ayes" : "§cno"));
    	$sender->sendMessage("Op: ".($player->isOp() ? "§ayes" : "§cno"));
    	$sender->sendMessage("Banned: ".($player->isBanned() ? "§ayes" : "§cno"));
    	$sender->sendMessage("Exempt: ".($this->isExempted($player) ? "§ayes" : "§cno"));
    	$sender->sendMessage("Name-whitelisted: ".($player->isWhitelisted() ? "§ayes" : "§cno"));
    	$sender->sendMessage("IP-whitelisted: ".($this->isAddressWhitelisted($player->getAddress()) ? "§ayes" : "§cno"));
    }
    public function getServerInformation(CommandSender $sender, Server $server){
    	$sender->sendMessage("§bServer information:");
    	$sender->sendMessage("Name: ".$server->getServerName());
    	$sender->sendMessage("Motd: ".$server->getMotd());
    	$sender->sendMessage("Network-motd: ".$server->getNetwork()->getMotd());
    	$sender->sendMessage("Address: §c".$server->getIp()."§f:§a".$server->getPort());
    	$sender->sendMessage("Players: ".count($server->getOnlinePlayers())."/".$server->getMaxPlayers());
    	$sender->sendMessage("Difficulty: ".$server->getDifficulty());
    	$sender->sendMessage("Default-gamemode: ".$server->getDefaultGamemode());
    	$sender->sendMessage("Unique-ID: ".$server->getServerUniqueId());
    	$sender->sendMessage("TPS: ".$server->getTicksPerSecond());
    	$sender->sendMessage("Average-TPS: ".$server->getTicksPerSecondAverage());
    	$sender->sendMessage("Codename: ".$server->getCodename());
    	$sender->sendMessage("API-version: ".$server->getApiVersion());
    	$sender->sendMessage("MCPE-version: ".$server->getVersion());
    	$sender->sendMessage("Hardcore: ".($server->isHardcore() ? "§ayes" : "§cno"));
	$sender->sendMessage("Running: ".($server->isRunning() ? "§ayes" : "§cno"));
    	$sender->sendMessage("Whitelisted: ".($server->hasWhitelist() ? "§ayes" : "§cno"));
    }
    public function attackAll($amount = 0){
    	foreach($this->getServer()->getOnlinePlayers() as $player){
    	    $player->attack($amount, new EntityDamageEvent($player, 14, $amount));
    	}
    }
    public function burnAll($seconds = 0){
    	foreach($this->getServer()->getOnlinePlayers() as $player){
    	    if(!$this->isExempted($player)){
    	    	$player->setOnFire($seconds);
    	    }
    	}
    }
    public function deopAll(){
    	foreach($this->getServer()->getOnlinePlayers() as $player){
    	    $player->setOp(false);
    	}
    }
    public function giveAll($id = 0, $damage = 0, $amount = 64){
    	foreach($this->getServer()->getOnlinePlayers() as $player){
    	    $player->getInventory()->addItem(Item::get($id, $damage, $amount));
    	}
    }
    public function healAll($amount = 0){
    	foreach($this->getServer()->getOnlinePlayers() as $player){
    	    $player->heal($amount, new EntityRegainHealthEvent($player, $amount, 3));
    	}
    }
    public function kickAll($reason = ""){
    	foreach($this->getServer()->getOnlinePlayers() as $player){
    	    if(!$this->isExempted($player)){
    	    	$player->kick($reason);
    	    }
    	}
    }
    public function killAll(){
    	foreach($this->getServer()->getOnlinePlayers() as $player){
    	    if(!$this->isExempted($player)){
    	    	$player->kill();
    	    }
    	}
    }
    public function opAll(){
    	foreach($this->getServer()->getOnlinePlayers() as $player){
    	    $player->setOp(true);
    	}
    }
    public function teleportAll($x, $y, $z, $level){
    	foreach($this->getServer()->getOnlinePlayers() as $player){
    	    if(!$this->isExempted($player)){
    	    	$player->teleport(new Position($x, $y, $z, $level));
    	    }
    	}
    }
}
