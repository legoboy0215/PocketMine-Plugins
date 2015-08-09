<?php

namespace skintools\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use skintools\SkinTools;

class SkinToolsCommand extends Command implements PluginIdentifiableCommand{
    public function __construct(SkinTools $plugin){
        parent::__construct(
            "skintools", 
            "Shows all the sub-commands for SkinTools", 
            "/skintools <sub-command> [parameters]", 
            array("st")
        );
        $this->setPermission("skintools.command.skintools");
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    private function sendCommandHelp(CommandSender $sender){

    }
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case "?":
                case "help":
                    break;
                case "morph":
                    if($sender instanceof Player and isset($args[1])){
                        if($sender->getServer()->getPlayer($args[1]) !== null){
                            $this->getPlugin()->setStolenSkin($sender, $sender->getServer()->getPlayer($args[1]));
                            $sender->sendMessage("You got ".$sender->getServer()->getPlayer($args[1])->getName()."'s skin.");
                        }
                    }
                    break;
                case "swap":
                    if($sender instanceof Player){
                        
                    }
                    else{
                        
                    }
                    break;
            }
        }
        else{
            $this->sendCommandHelp($sender);
            return true;
        }
    }
}
