<?php

namespace locatorpro\command;

use locatorpro\LocatorProAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;

class LocatorProCommand extends Command implements PluginIdentifiableCommand{
    public function __construct(LocatorProAPI $plugin){
        parent::__construct(
            "locatorpro", 
            "Shows all the sub-commands for /locatorpro", 
            "/locatorpro <sub-command> [parameters]", 
            array("lp")
        );
        $this->setPermission("locatorpro.command.locatorpro");
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    private function sendCommandHelp(CommandSender $sender){
        $sender->sendMessage("§bLocatorPro commands:");
        $sender->sendMessage("§a/locatorpro back §c- §f");
        $sender->sendMessage("§a/locatorpro help §c- §fShows all the sub-commands for /locatorpro");
        $sender->sendMessage("§a/locatorpro pos §c- §f");
        $sender->sendMessage("§a/locatorpro save §c- §f");
        $sender->sendMessage("§a/locatorpro set §c- §f");  
    }
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case 'back':
                    break;
                case '?':
                case 'help':
                    break;
                case 'gp':
                case 'getpos':
                    break;
                case 'sp':
                case 'savepos':
                    break;
                case 'ss':
                case 'setspawn':
                    break;
            }
        }
        else{
            $this->sendCommandHelp($sender);
            return true;
        }
    }
}
