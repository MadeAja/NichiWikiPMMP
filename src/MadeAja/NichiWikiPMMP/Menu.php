<?php


namespace MadeAja\NichiWikiPMMP;


use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\Player;

class Menu
{
    /**
     * @param Player $player
     */
    public static function sendCustomForm(Player $player)
    {
        $data['title'] = "Wikipedia";
        $data['type'] = "custom_form";
        $data["content"][] = ["type" => "label", "text" => "Search a something\n\n"];
        $data["content"][] = ["type" => "input", "text" => "Search wiki", "placeholder" => "Write here", "default" => null];
        $packet = new ModalFormRequestPacket();
        $packet->formId = 12931723;
        $packet->formData = json_encode($data);
        $player->dataPacket($packet);
    }

    /**
     * @param Player $player
     * @param $data
     */
    public static function sendSuccessQuery(Player $player, $data, $time)
    {
        $dataArray = [];
        if(isset($data['pages']['-1'])){
            self::sendCustomForm($player);
            return;
        }
        foreach ($data['pages'] as $array){
            $dataArray = $array;
        }
        $textArray = str_split($dataArray['extract'], 40);
        $text = implode("\n", $textArray);
        $data['title'] = "§5Query success: §7[§3".round(microtime(true) - $time, 3) . "s§7]";
        $data['type'] = "form";
        foreach (["Exit", "Search"] as $name) {
            $data['buttons'][] = ['text' => $name];
        }
        $data["content"] = $text;
        $packet = new ModalFormRequestPacket();
        $packet->formId = 4535;
        $packet->formData = json_encode($data);
        $player->dataPacket($packet);
    }
}