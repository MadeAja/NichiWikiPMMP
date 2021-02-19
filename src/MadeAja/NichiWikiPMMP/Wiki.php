<?php


namespace MadeAja\NichiWikiPMMP;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Wiki extends PluginBase
{
   public function onEnable()
   {
       $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
   }
    /**
     * @param CommandSender $sender
     * @param Command $command
     * @param string $label
     * @param array $args
     * @return bool
     */
   public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
   {
       switch ($command->getName()){
           case "wiki":
               if(!$sender instanceof Player){
                   $sender->sendMessage("Use command player");
                   return false;
               }
               Menu::sendCustomForm($sender);
               break;
       }
       return true;
   }
}