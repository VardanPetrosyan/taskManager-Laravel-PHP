<?php

namespace App\Helper;

use App\Models\User;
use \Session;

class AuthHelper
{
	private static $init = false;
	private static $user = null;

	private static function init()
	{
		if (self::$init) {
			return;
		}

		self::$init = true;

		$id = Session::get('logged_admin_id');
		if (is_null($id)) {
			return;
		}

		self::$user = User::find($id);
		if (is_null(self::$user)) {
			self::logout();
		}
	}

	public static function login(User $user)
	{
		self::init();

		self::$user = $user;
		Session::put('logged_admin_id', $user->id);
        Session::put('logged_admin_name', $user->name);
	}

	public static function logout()
	{
		self::init();

		self::$user = null;
		Session::remove('logged_admin_id');
	}

	public static function check()
	{
		self::init();

		return !is_null(self::$user);
	}

	public static function guest()
	{
		self::init();

		return is_null(self::$user);
	}

	public static function user()
	{
		self::init();

		return self::$user;
	}
}
