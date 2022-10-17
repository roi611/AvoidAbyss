<?php
    
namespace roi611\abyss;
    
use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\world\Position;
use pocketmine\utils\Config;
    
class Main extends PluginBase implements Listener{
    
    public function onEnable():void {

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveResource('config.yml');
        $this->config = new Config($this->getDataFolder()."config.yml", Config::YAML);

    }

    public function onMove(PlayerMoveEvent $event){

        $player = $event->getPlayer();
        $world = $player->getWorld();
        $name = $world->getFolderName();
        $pos = $this->config->get($name,null);
        if($pos !== null){

            $data = explode(",",$pos);
            $pos = $player->getPosition();
            $y = $pos->y;
            if((int)$data[0] >= $y){
                $p = new Position($pos->x,(int)$data[1],$pos->z,$world);
                $player->teleport($p);
                $player->sendTip("[§4AvoidAbyss§r]\n対象の高さになったためテレポートしました");
            }

        }

    }
        
}