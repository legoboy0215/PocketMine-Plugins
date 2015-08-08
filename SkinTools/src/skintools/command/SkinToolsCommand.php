<?php

namespace skintools\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use skintools\SkinTools;

class SkinToolsCommand extends Command implements PluginIdentifiableCommand{
    public function __construct(EasyMessages $plugin){
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
            }
        }
        else{
            $this->sendCommandHelp($sender);
            return true;
        }
    }
}
