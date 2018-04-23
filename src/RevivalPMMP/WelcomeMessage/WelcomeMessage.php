<?php

namespace RevivalPMMP\WelcomeMessage;

use pocketmine\plugin\PluginBase;

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