<?php
/**
 *
 * User ID in Viewtopic extension for the phpBB Forum Software package
 *
 * @copyright (c) 2026, phpBB Modders, https://www.phpbbmodders.com/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbmodders\useridviewtopic\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * User ID in Viewtopic event listener
 */
class main_listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config  $config
	 */
	public function __construct(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	/**
	 * Map phpBB core events to the listener methods
	 *
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup'	=> 'user_setup',

			'core.acp_board_config_edit_add'	=> 'acp_board_config_edit_add',

			'core.viewtopic_modify_post_row'	=> 'viewtopic_modify_post_row',
		];
	}

	/**
	 * Load common language files
	 *
	 * @param \phpbb\event\data	$event
	 */
	public function user_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'phpbbmodders/useridviewtopic',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Add and/or modify acp_board configurations
	 */
	public function acp_board_config_edit_add($event)
	{
		if ($event['mode'] == 'load')
		{
			$config_vars = [
				'load_userid_viewtopic'	=> ['lang' => 'LOAD_USERID_VIEWTOPIC', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
			];

			$event->update_subarray('display_vars', 'vars', phpbb_insert_config_array($event['display_vars']['vars'], $config_vars, ['after' => 'load_cpf_viewtopic']));
		}
	}

	/**
	 * Modify the posts template block
	 */
	public function viewtopic_modify_post_row($event)
	{
		$event->update_subarray('post_row', 'S_USERID_VIEWTOPIC', $this->config['load_userid_viewtopic'] ? true : false);
	}
}
