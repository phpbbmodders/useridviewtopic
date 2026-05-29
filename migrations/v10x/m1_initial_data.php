<?php
/**
 *
 * User ID in Viewtopic extension for the phpBB Forum Software package
 *
 * @copyright (c) 2026, phpBB Modders, https://www.phpbbmodders.com/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbmodders\useridviewtopic\migrations\v10x;

class m1_initial_data extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->config->offsetExists('load_userid_viewtopic');
	}

	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v330\v330'];
	}

	/**
	 * Add, update or delete data
	 *
	 * @return array
	 */
	public function update_data()
	{
		return [
			// Add config table settings
			['config.add', ['load_userid_viewtopic', 1]],
		];
	}
}
