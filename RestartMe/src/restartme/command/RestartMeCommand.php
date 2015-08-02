<?php

namespace restartme\command;

use restartme\RestartMeAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginIdentifiableCommand;

class RestartMeCommand extends Command implements PluginIdentifiableCommand{
    public function __construct(RestartMeAPI $plugin){
        parent::__construct(
            "restartme", 
            "Shows all the sub-commands for RestartMe", 
            "/restartme <sub-command> [parameters]", 
            array("rm")
        );
        $this->setPermission("restartme.command.restartme");
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    private function sendCommandHelp(CommandSender $sender){
        $sender->sendMessage("§bRestartMe commands:");
        $sender->sendMessage("§a/restartme add §c- §fDelays the server restart by n seconds");
        $sender->sendMessage("§a/restartme help §c- §fShows all the sub-commands for RestartMe");
        $sender->sendMessage("§a/restartme subtract §c- §fAdvances the server restart by n seconds");
        $sender->sendMessage("§a/restartme time §c- §fGets the remaining time until the server restarts");
    }
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case 'add':
                    break;
                case '?':
                case 'help':
                    break;
                case 'subtract':
                    break;
                case 'time':
                    break;
            }
        }
        else{
            $this->sendCommandHelp($sender);
        }
    }
}
