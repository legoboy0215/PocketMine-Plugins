<?php

namespace easymessages\command;

use easymessages\EasyMessages;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;

class EasyMessagesCommand extends Command implements PluginIdentifiableCommand{
    public function __construct(EasyMessages $plugin){
        parent::__construct(
            "easymessages", 
            "Shows all the sub-commands for EasyMessages", 
            "/easymessages <sub-command> [parameters]", 
            array("em")
        );
        $this->setPermission("easymessages.command.easymessages");
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    private function sendCommandHelp(CommandSender $sender){
        $sender->sendMessage("§6EasyMessages §bcommands:");
        $sender->sendMessage("§dMain command: §9easymessages§d, §9em");
        $sender->sendMessage("§abroadcastmessage§3/§abm: §fBroadcasts a message to all players");
        $sender->sendMessage("§abroadcastpopup§3/§abp: §fBroadcasts a popup to all players");
        $sender->sendMessage("§abroadcasttip§3/§abt: §fBroadcasts a tip to all players");
        $sender->sendMessage("§ahelp: §fShows all the sub-commands for EasyMessages");
        $sender->sendMessage("§asendmessage§3/§asm: §fSends a message to the specified player");
        $sender->sendMessage("§asendpopup§3/§asp: §fSends a popup to the specified player");
        $sender->sendMessage("§asendtip§3/§ast: §fSends a tip to the specified player");
    }
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case 'bm':
                case 'broadcastmessage':
                    break;
                case 'bp':
                case 'broadcastpopup':
                    break;
                case 'bt':
                case 'broadcasttip':
                    break;
                case '?':
                case 'help':
                    break;
                case 'sm':
                case 'sendmessage':
                    break;
                case 'sp':
                case 'sendpopup':
                    break;
                case 'st':
                case 'sendtip':
                    break;
            }
        }
        else{
            $this->sendCommandHelp($sender);
            return true;
        }
    }
}
