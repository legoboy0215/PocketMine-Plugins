<?php

namespace mytag\command;

use mytag\MyTag;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;

class MyTagCommand extends Command implements PluginIdentifiableCommand{
    public function __construct(MyTag $plugin){
        parent::__construct(
            "mytag", 
            "Shows all the sub-commands for /mytag", 
            "/mytag <sub-command> [parameters]", 
            array("mt")
        );
        $this->setPermission("mytag.command.mytag");
    	$this->plugin = $plugin;
    }
    public function getPlugin(){
    	return $this->plugin;
    }
    private function sendCommandHelp(CommandSender $sender){
    	$sender->sendMessage("§bMyTag commands:");
    	$sender->sendMessage("§a/mytag address §c- §fShows IP address and port number on the name tag");
    	$sender->sendMessage("§a/mytag chat §c- §fShows the last message spoken on the name tag");
    	$sender->sendMessage("§a/mytag health §c- §fShows health on the name tag");
    	$sender->sendMessage("§a/mytag help §c- §fShows all the sub-commands for /mytag");
    	$sender->sendMessage("§a/mytag hide §c- §fHides the name tag");
    	$sender->sendMessage("§a/mytag restore §c- §fRestores current name tag to the default name tag");
    	$sender->sendMessage("§a/mytag set §c- §fSets the name tag to whatever is specified");
    	$sender->sendMessage("§a/mytag view §c- §fShows the name tag with a message");
    }
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
	    switch(strtolower($args[0])){
	    	case 'address':
	    	    break;
	    	case 'chat':
	    	    break;
	    	case 'health':
	    	    break;
	    	case '?':
	    	case 'help':
	    	    break;
	    	case 'hide':
	      	    break;
	      	case 'restore':
	            break;
	        case 'set':
	            break;
	        case 'view':
	            break;
	    }
    	}
    	else{
	    $this->sendCommandHelp($sender);
	    return true;
    	}
    }
}
