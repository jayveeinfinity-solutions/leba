<?php
	$GLOBALS['config'] = array(
		'info' => array(
			'appname' => 'Leba E-Commerce',
			'appurl' => 'https://leba.test/'
		),
		'mysql' => array(
			'host' => '127.0.0.1',
			'username' => 'root',
			'password' => '',
			'database' => 'leba',
		)
	);

	spl_autoload_register(function($class) {
		// require_once $_SERVER['DOCUMENT_ROOT'] . '/app/controllers/' . $class . '.php';
		//require_once 'app/controllers/' . $class . '.php';
		$root = __DIR__;
		$className = basename(str_replace('\\', '/', $class));

		$controllersPath = $root . '/controllers/';
		$seedersPath     = $root . '/database/seeders/';

		if (strpos($className, 'IB_') === 0) {
			$file = $controllersPath . $className . '.php';
		}
		elseif (preg_match('/Seeder$/i', $className)) {
			$file = $seedersPath . $className . '.php';
		}
		else {
			$file = $controllersPath . $className . '.php';
		}

		if (file_exists($file)) {
			require_once $file;
		} else {
			echo "❌ Autoload failed: class {$className} not found in {$file}\n";
		}
	});

	session_start();
?>