<?php


namespace MadeAja\NichiWikiPMMP;


use MadeAja\NichiWikiPMMP\thread\QueryAsyncTask;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;

class EventListener implements Listener
{

    private $wiki;

    public function __construct(Wiki $wiki)
    {
        $this->wiki = $wiki;
    }
    /**
     * @param DataPacketReceiveEvent $event
     */
    public function handlePacket(DataPacketReceiveEvent $event) : void{
        $packet = $event->getPacket();
        $player = $event->getPlayer();

        if($packet instanceof ModalFormResponsePacket){
            $data = json_decode($packet->formData);
            if (is_null($data)) {
                return;
            }
            if($packet->formId == 12931723) {
                if(empty($data[1])){
                    Menu::sendCustomForm($player);
                    return;
                }
                $this->wiki->getServer()->getAsyncPool()->submitTask(new QueryAsyncTask($player, $data[1], microtime(true)));
            }elseif ($packet->formId === 4535){
                if($data === 1) {
                    Menu::sendCustomForm($player);
                }
            }
        }
    }
}