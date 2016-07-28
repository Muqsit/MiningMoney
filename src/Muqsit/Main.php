<?php
namespace Muqsit;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\utils\Config;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener{

  public function onEnable(){
  	@mkdir($this->getDataFolder());
    $this->saveDefaultConfig();
    $this->reloadConfig();
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  
  public function mine(BlockBreakEvent $e){
    $p = $e->getPlayer();
    $cfg = $this->getConfig();
    $block = $e->getBlock();
    $message = $cfg->get("reward-message");

    if($cfg->get($block->getId()) !== null && $cfg->get($block->getId()) > 0){
      EconomyAPI::getInstance()->addMoney($p, $cfg->get($block->getId()));
      $p->sendMessage($message);
    }else{
      return false;
    }
  }
}
