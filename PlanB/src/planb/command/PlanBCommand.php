<?php

namespace planb\command;

use planb\PlanB;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginIdentifiableCommand;

class PlanBCommand extends Command implements PluginIdentifiableCommand{
    public function __construct(PlanB $plugin){
        parent::__construct(
            "planb", 
            "Shows all the sub-commands for PlanB", 
            "/planb <sub-command> [parameters]", 
            array("pb")
        );
        $this->setPermission("planb.command.planb");
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    private function sendCommandHelp(CommandSender $sender){
        $sender->sendMessage("§bPlanB commands:");
        $sender->sendMessage("§a/planb addbackup §c- §fAdds a player to backups.txt");
        $sender->sendMessage("§a/planb delbackup §c- §fRemoves a player from backups.txt");
        $sender->sendMessage("§a/planb help §c- §fShows all the sub-commands for PlanB");
        $sender->sendMessage("§a/planb list §c- §fLists all backup players");
        $sender->sendMessage("§a/planb restore §c- §fRestores OP status of all online players listed in backup.txt");
    }
    public function execute(CommandSender $sender, $label, array $args){
        if(isset($args[0])){
            if(strtolower($args[0]) === "addbackup" or strtolower($args[0]) === "ab"){
                if(isset($args[1])){
                    if($sender instanceof ConsoleCommandSender){
                        if($this->getPlugin()->isBackupPlayer($args[1])){
                            $sender->sendMessage("§c".$args[1]." already exists in backups.txt.");
                        }
                        else{
                            $this->getPlugin()->addBackup($args[1]);
                            $sender->sendMessage("§aAdded ".$args[1]." to backups.txt.");
                        }
                    }
                    else{
                        $sender->sendMessage("§cPlease run this command on the console.");
                    }
                }
                else{
                    $sender->sendMessage("§cPlease specify a valid player."); 
                }
                return true;
            }
            if(strtolower($args[0]) === "delbackup" or strtolower($args[0]) === "db"){
                if(isset($args[1])){
                    if($sender instanceof ConsoleCommandSender){
                        if($this->getPlugin()->isBackupPlayer($args[1])){
                            $this->getPlugin()->removeBackup($args[1]);
                            $sender->sendMessage("§aRemoved ".$args[1]." from backups.txt.");
                        }
                        else{
                            $sender->sendMessage("§c".$args[1]." does not exist in backups.txt.");
                        }
                    }
                    else{
                        $sender->sendMessage("§cPlease run this command on the console.");
                    }
                }
                else{
                    $sender->sendMessage("§cPlease specify a valid player.");
                }
                return true;
            }
            if(strtolower($args[0]) === "help"){
                $this->sendCommandHelp($sender);
                return true;
            }
            if(strtolower($args[0]) === "list"){
                $this->getPlugin()->sendBackups($sender);
                return true;
            }
            if(strtolower($args[0]) === "restore"){
                if($this->getPlugin()->isBackupPlayer($sender->getName()) or $sender instanceof ConsoleCommandSender){
                    $this->getPlugin()->restoreOps();
                    $sender->sendMessage("§aRestoring the statuses of OPs...");
                }
                else{
                    $sender->sendMessage("§cYou do not not have permissions to restore OPs.");
                }
                return true;
            }
            else{
                $sender->sendMessage("§cUsage: ".$this->getUsage());
            }
        }
        else{
            $this->sendCommandHelp($sender);
        }
    }
}
