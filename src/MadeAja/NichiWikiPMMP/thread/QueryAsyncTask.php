<?php


namespace MadeAja\NichiWikiPMMP\thread;


use MadeAja\NichiWikiPMMP\Menu;
use pocketmine\Player;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\utils\Internet;
use function json_decode;

class QueryAsyncTask extends AsyncTask
{

    /**
     * @var string $search
     */
    private $search;
    /**
     * @var int $time
     */
    private $time;


    public function __construct(Player $player, $search, $time)
    {
        $this->search = $search;
        $this->time = $time;
        $this->storeLocal($player);
    }

    public function onRun()
    {
        $data = Internet::getURL("https://id.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro&explaintext&redirects=1&titles=".$this->search);
        $data = json_decode($data, true);
        $this->setResult($data['query']);
    }

    /**
     * @param Server $server
     */
    public function onCompletion(Server $server)
    {
        Menu::sendSuccessQuery($this->fetchLocal(), $this->getResult(), $this->time);
    }
}
