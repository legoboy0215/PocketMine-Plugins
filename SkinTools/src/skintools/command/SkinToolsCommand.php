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
        $sender->sendMessage("§bSkinTools commands:");
        $sender->sendMessage("§a/skintools help §c- §fShows all the sub-commands for SkinTools");
        $sender->sendMessage("§a/skintools morph §c- §fSets user's skin to that of the specified player's");
        $sender->sendMessage("§a/skintools restore §c- §fRestores user's skin to the skin they joined with");
        $sender->sendMessage("§a/skintools swap §c- §fSwaps skins with the specified player");
        $sender->sendMessage("§a/skintools touch §c- §fToggles touch mode");
    }
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
            switch(strtolower($args[0])){
                case "?":
                case "help":
                    $this->sendCommandHelp($sender);
                    break;
                case "morph":
                    if($sender instanceof Player){
                        if(isset($args[1])){
                            if($sender->getServer()->getPlayer($args[1]) !== null){
                                $this->getPlugin()->setStolenSkin($sender, $sender->getServer()->getPlayer($args[1]));
                                $sender->sendMessage("§aYou got ".$sender->getServer()->getPlayer($args[1])->getName()."'s skin.");
                            }
                            else{
                                $sender->sendMessage("§cThat player could not be found.");
                            }
                        }
                        else{
                            $sender->sendMessage("§cPlease specify a valid player.");
                        }
                    }
                    else{
                        $sender->sendMessage("§cPlease run this command in-game.");
                    }
                    break;
                case "restore":
                    if($sender instanceof Player){
                        $sender->setSkin($this->getPlugin()->getSkinData($sender));
                        $sender->sendMessage("§aYour original skin has been restored.");
                    }
                    else{
                        $sender->sendMessage("§cPlease run this command in-game.");
                    }
                    break;
                case "swap":
                    if($sender instanceof Player){
                        
                    }
                    else{
                        
                    }
                    break;
                case "touch":
                    if($sender instanceof Player){
                        if($this->getPlugin()->hasTouchMode($sender)){
                            $this->getPlugin()->setTouchMode($sender, false);
                            $sender->sendMessage("§cSkin-touch mode disabled.");
                        }
                        else{
                            $this->getPlugin()->setTouchMode($sender, true);
                            $sender->sendMessage("§aSkin-touch mode enabled. Tap on a player to get their skin.");
                        }
                    }
                    else{
                        $sender->sendMessage("§cPlease run this command in-game.");
                    }
                    break;
                default:
                    $sender->sendMessage("Usage: ".$this->getUsage());
                    break;
            }
        }
        else{
            $this->sendCommandHelp($sender);
            return true;
        }
    }
}
