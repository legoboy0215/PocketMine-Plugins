<?php

namespace queryfacade\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use queryfacade\QueryFacade;

class QueryFacadeCommand extends Command implements PluginIdentifiableCommand{
    public function __construct(QueryFacade $plugin){
        parent::__construct(
            "queryfacade", 
            "Shows all the sub-commands for /queryfacade", 
            "/queryfacade <sub-command> [parameters]", 
            array("qf")
        );
        $this->setPermission("queryfacade.command.queryfacade");
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    private function sendCommandHelp(CommandSender $sender){
        $sender->sendMessage("§bQueryFacade commands:");
        $sender->sendMessage("§a/queryfacade help §c- §fShows all the sub-commands for /queryfacade");
    }
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case '?':
                case 'help':
                    break;
            }
        }
        else{
            $this->sendCommandHelp($sender);
            return true;
        }
    }
}
