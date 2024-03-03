<?php

namespace PrCustom\Controller;

use PrCustom\Support\Log;
use PrCustom\Support\Request;
use PrCustom\Support\Resource;
use PrCustom\Wordpress\PrCustom;

/**
 * Provides the settings and admin page
 */
class AdminAjaxController extends Request
{
	/**
	 * Plugin.
	 *
	 * @var PrCustom
	 */
	protected $plugin;

	/**
	 * Bootstraps the admin part
	 *
	 * @param PrCustom $plugin Plugin.
	 */
	public function __construct($plugin)
	{
		$this->plugin = $plugin;

		$method = ! $this->function() ? : $this->function();

		if ($method == 'asyncContent' || $method == 'asyncComponent') {

			$this->view();

		} else {
			if (! method_exists($this, $method)) {
				wp_send_json_error(['error' => $method.'() method not found']);
			}

			$method = $this->$method();
			if (isset($method)) {
				isset($method->error) ?	wp_send_json_error(['error' => $method->error]) : wp_send_json_success($method);
			}
		}
	}

	/**
	 * Set view resource
	 */
	public function view()
	{
		$data = new \stdClass;

		$tab = $this->post()->tab ?? '';
		if ($tab) {
			$data->resource = new Resource;

			$json = file_get_contents(dirname(__DIR__, 1) . '/json/users.json');
			$json = json_decode($json);
			$users = ! isset($json->users) ? [] : $json->users;

			$filter = $this->post()->filter ?? [
				'page' => 1,
				'name' => '',
            	'email' => '',
            	'surname' => ''
			];
			$filter = (object) $filter;
			$data->filter = $filter;


			if (strlen($filter->name) >= 1 || strlen($filter->surname) >= 1 || strlen($filter->email) >= 1) {
				foreach ($users as $key => $user) {
					$name  = strlen($filter->name)    == 0 ? 0 : preg_match('/'.$filter->name.'/i', $user->name);
					$surn1 = strlen($filter->surname) == 0 ? 0 : preg_match('/'.$filter->surname.'/i', $user->surname_1);
					$surn2 = strlen($filter->surname) == 0 ? 0 : preg_match('/'.$filter->surname.'/i', $user->surname_2);
					$email = strlen($filter->email)   == 0 ? 0 : preg_match('/'.$filter->email.'/i', $user->email);
					$matches = $name + $surn1 + $surn2 + $email;
					if ($matches == 0) {
						unset($users[$key]);
					}
				}
			}

			$page = $filter->page;
			$limit = 5;
			$total = count($users);
			$pages = ceil($total / $limit);
			$from = ($page * $limit) - $limit;
			$output = array_splice($users, $from, $limit);

			$data->pagination = (object) [
				'total' => $total,
				'page'  => $page,
				'pages' => $pages,
				'first' => $page > 1 ? true : false,
				'prev'  => $page > 1 ? true : false,
				'next'  => $page < $pages ? true : false,
				'last'  => $page < $pages ? true : false
			];

			$data->users = $output;

			echo (new Resource)->view('admin.section.'.$tab, $data);
			exit;
		}
	}

	/**
	 * Methods
	 */
	public function example()
	{
		$response = new \stdClass;

		$response->method = __FUNCTION__;

		return $response;
	}

	public function createUsersJsonFile()
	{
		$users = [];
		for ($i = 1; $i <= 50; $i++) {
			if ($i == 1) {
				$users[] = (object) [
					'id' => $i,
					'user' => 'admin',
					'name' => 'admin',
					'surname_1' => 'admin',
					'surname_2' => 'admin',
					'email' => 'admin@yopmail.com'
				];
			} else {
				$users[] = (object) [
					'id' => $i,
					'user' => 'admin'.$i,
					'name' => 'admin'.$i,
					'surname_1' => 'admin'.$i,
					'surname_2' => 'admin'.$i,
					'email' => 'admin'.$i.'@yopmail.com'
				];
			}
		}

		$json = ['users' => $users];

		$file = dirname(__DIR__, 1) . '/json/users.json';
		file_put_contents($file, json_encode($json));
	}

	public function emptyUsersJsonFile()
	{
		$json = [];
		$file = dirname(__DIR__, 1) . '/json/users.json';
		file_put_contents($file, json_encode($json));
	}

}
