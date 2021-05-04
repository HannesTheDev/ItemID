<?php

namespace HannesTheDev\ItemID;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class Main extends PluginBase
{

    public $config;
    public $prefix;

    public function onEnable()
    {
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->prefix = $this->config->get("prefix");
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool
    {
        switch ($cmd->getName()) {
            case "id":
                if ($sender instanceof Player) {
                    $item = $sender->getInventory()->getItemInHand();
                    $itemid = $this->config->get("itemid");
                    $itemid = str_replace('{id}', $item->getId(), $itemid);
                    $itemid = str_replace('{damage}', $item->getDamage(), $itemid);
                    $itemid = str_replace('{block_name}', $item->getName(), $itemid);
                    $sender->sendMessage($itemid);
                }
                break;
        }
        return true;
    }
}