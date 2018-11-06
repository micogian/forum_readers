<?php
/**
*
* Total readers on index extension for the phpBB Forum Software package.
*
* @copyright (c) 2018 Giovanni Dose (Micogian)
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace micogian\forum_readers\event;
/**
* Event listener
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $db;
	protected $template;
	protected $auth;
	protected $user;
	protected $root_path;
	protected $phpEx;

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\auth\auth $auth, \phpbb\user $user, $root_path )
	{
		$this->db = $db;
		$this->template = $template; 
		$this->auth = $auth;
		$this->user = $user;
		$this->root_path = $root_path;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'							=> 'load_language_on_setup',
			'core.display_forums_modify_template_vars'	=> 'forums_modify_template_vars',
		);
	}
	public function load_language_on_setup($event)	
	{	
		//language start
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'micogian/readers',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	public function forums_modify_template_vars($event)
	{
		$forum_row = $event['forum_row'];	
		
		$row = $event['row'];
		$forum_id	= $row{'forum_id'};
		$forum_name	= $row{'forum_name'};
		$parent_id	= $row['parent_id'];
		
		// Total readers inizio prima parte
        $array_readers = obtain_users_online($forum_id);
        $total_readers = $array_readers['guests_online'] + $array_readers['visible_online'];
        $sql_readers = 'SELECT *
            FROM ' . FORUMS_TABLE . "
            WHERE parent_id = $forum_id";
        $result_readers = $this->db->sql_query($sql_readers);
            while($row_readers = $this->db->sql_fetchrow($result_readers)){
                $array_readers = obtain_users_online($row_readers['forum_id']);
                $total_readers = $total_readers + $array_readers['guests_online'] + $array_readers['visible_online'];
            }
		// Total readers fine prima parte

			$readers_row = array(
				'TOT_READERS'			=> $total_readers,					
			);
		$forum_row = array_merge($forum_row, $readers_row);
		$event['forum_row'] = $forum_row ;			
	}
}
