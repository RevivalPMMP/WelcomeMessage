<?php

namespace RevivalPMMP\WelcomeMessage;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

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