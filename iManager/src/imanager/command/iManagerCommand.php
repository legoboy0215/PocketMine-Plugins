<?php

namespace imanager\command;

use imanager\iManagerAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;

class iManagerCommand extends Command implements PluginIdentifiableCommand{
    public function __construct(iManagerAPI $plugin){
        parent::__construct(
            "imanager", 
            "Shows all the sub-commands for iManager", 
            "/imanager <sub-command> [parameters]", 
            array("im")
        );
        $this->setPermission("imanager.command.imanager");
    	$this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    private function sendCommandHelp(CommandSender $sender){
    	$sender->sendMessage("§6iManager §bcommands:");
    	$sender->sendMessage("§dMain command: §9imanager§d, §9im");
    	$sender->sendMessage("§aaddexempt/ae: §fAdds a player's name to exempt.txt");
    	$sender->sendMessage("§aaddip/ai: §fAdds a player's IP address to ip.txt");
    	$sender->sendMessage("§aaddresslist/al: §fLists every player's IP address and port");
    	$sender->sendMessage("§aattackall/aa: §fAttacks all the players in the server");
    	$sender->sendMessage("§aburnall/ba: §fBurns all the players without EXEMPT status in the server");
    	$sender->sendMessage("§adelexempt/de: §fRemoves a player's name from exempt.txt");
    	$sender->sendMessage("§adelip/di: §fRemoves a player's IP address from ip.txt");
    	$sender->sendMessage("§adeopall/da: §fRevokes all the player's OP status");
    	$sender->sendMessage("§agiveall/ga: §fGives the specified item to all players in the server");
    	$sender->sendMessage("§ahealall/ha: §fHeals all the players in the server");
    	$sender->sendMessage("§ahelp: §fShows all the sub-commands for iManager");
    	$sender->sendMessage("§ainfo: §fGets all the information about a player");
    	$sender->sendMessage("§akickall/kka: §fKicks all the players without EXEMPT status from the server");
    	$sender->sendMessage("§akillall/kla: §fKills all the players without EXEMPT status in the server");
    	$sender->sendMessage("§aopall/oa: §fGrants OP status to everyone in the server");
    	$sender->sendMessage("§aoplist/ol: §fLists all the OPs");
    	$sender->sendMessage("§aserver: §fShows all the information about the server");
    	$sender->sendMessage("§atpall/ta: §fTeleports all players in the server without EXEMPT status to the given location");
    }
    public function execute(CommandSender $sender, $label, array $args){
    	if(isset($args[0])){
    	    switch(strtolower($args[0])){

    	    }
    	}
    	else{
	    $this->sendCommandHelp($sender);
    	    return true;
    	}
    }
}
