<?php

namespace RevivalPMMP\WelcomeMessage;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;

class WelcomeMessage extends PluginBase{

	const TITLE = "title";
	const SUBTITLE = "subtitle";
	const DELAY = "delay";
	const FADE_IN = "fade-in";
	const FADE_OUT = "fade-out";
	const STAY = "stay";


	private $msg = [];

	/**
	 * @var WelcomeMessage
	 */
	private static $instance;

	public function onEnable(){
		self::$instance = $this;
		$this->reload();
		$this->getServer()->getPluginManager()->registerEvents(new WelcomeListener($this, $this->msg[self::DELAY]), $this);
	}

	public function reload(){
		$this->saveDefaultConfig();
		$cfg = $this->getConfig();
		$this->msg[self::TITLE] = $cfg->get(self::TITLE);
		$this->msg[self::SUBTITLE] = $cfg->get(self::SUBTITLE);
		$this->msg[self::DELAY] = $cfg->get(self::DELAY);
		$this->msg[self::FADE_IN] = $cfg->get(self::FADE_IN);
		$this->msg[self::FADE_OUT] = $cfg->get(self::FADE_OUT);
		$this->msg[self::STAY] = $cfg->get(self::STAY);
	}

	public static function getInstance() : WelcomeMessage {
		return self::$instance;
	}

	public function getMessage(){
		return $this->msg;
	}
}

class BroadcastTitle extends Task{

	private $player;
	private $msg;
	

	public function __construct(Player $player){
		$this->player = $player;
		$this->msg = WelcomeMessage::getInstance()->getMessage();
	}
	public function onRun(int $currentTick){
		$this->player->getServer()->broadcastTitle($this->msg[WelcomeMessage::TITLE],
			$this->msg[WelcomeMessage::SUBTITLE],
			$this->msg[WelcomeMessage::FADE_IN],
			$this->msg[WelcomeMessage::STAY],
			$this->msg[WelcomeMessage::FADE_OUT],
			[$this->player]
		);
	}
}

class WelcomeListener implements Listener {

    /**
     * @var WelcomeMessage
     */
    private $plugin;

    private $delay;

    public function __construct(WelcomeMessage $plugin, int $delay) {
        $this->plugin = $plugin;
        $this->delay = $delay;
    }

    public function playerJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        $this->plugin->getLogger()->info($player->getName() . " Joined");
        $this->plugin->getServer()->getScheduler()->scheduleDelayedTask(new BroadcastTitle($player), $this->delay);
    }
}