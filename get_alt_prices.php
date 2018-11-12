<?php

chdir(dirname(__FILE__));

include_once './tickerEntity.php';

define('DB_HOST', 'localhost');
define('DB_LOGIN', 'root');
define('DB_PASS', '');
define('DB_NAME', 'database');

try {
	$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_LOGIN, DB_PASS);
} catch (Exception $e) {
	throw new Exception("Could not connect: Mysql Server.");
}

// Class autoloding
spl_autoload_register(function ($class_name) {
	include_once './Sources/Alt/' . $class_name . '.php';
});

$prices = [];
$classes = [];

$directory = opendir('./Sources/Alt');
while (false !== ($file = readdir($directory))) {
	if (substr($file, -4) === '.php') {
		$classes[] = substr($file, 0, -4);
	}
}
closedir($directory);

if (count($classes) == 0) {
	exit("Empty classes");
}

$db->query("INSERT INTO `currency_rates_id` (`datetime`) VALUES(now())");
$id = $db->lastInsertId();

foreach ($classes as $className) {
	$class = new $className();
	$price = $class->getPrice();
	if (!empty($price)) {
		foreach ($price as $coin => $val) {
			try {
				$query = $db->prepare("INSERT INTO `currency_rates_log` (`id`, `currency`, `amount`, `date`, `source`) VALUES(:id, :coin, :amount, now(), :source)");
				$query->bindParam(':id', $id, PDO::PARAM_INT);
				$query->bindParam(':coin', $coin, PDO::PARAM_STR);
				$query->bindParam(':amount', $val, PDO::PARAM_STR);
				$query->bindParam(':source', $class->source, PDO::PARAM_INT);
				$query->execute();
			} catch (Exception $e) {
				var_dump($e->getMessage());
				continue;
			}
		}
	} else {
		var_dump($class);
	}
}

try {
	$query = $db->prepare("SELECT `currency`, AVG(`AMOUNT`) FROM `currency_rates_log` WHERE `id` = :id GROUP BY `currency`");
	$query->bindParam(':id', $id, PDO::PARAM_INT);
	$query->execute();
	$result = $query->fetchAll(PDO::FETCH_NUM);
} catch (Exception $e) {
	var_dump($e->getMessage());
	exit();
}

if (empty($result)) {
	var_dump($result, $query, $id, $classes, $price);
	exit('Result is empty');
}

$db->query("TRUNCATE `currency_rates`;");

foreach ($result as $key => $val) {
	try {
		$query = $db->prepare("INSERT INTO `currency_rates` (`currency`, `amount`) VALUES(:coin, :amount)");
		$query->bindParam(':coin', $val[0], PDO::PARAM_STR);
		$query->bindParam(':amount', $val[1], PDO::PARAM_STR);
		$query->execute();
	} catch (Exception $e) {
		var_dump($e->getMessage());
		continue;
	}
}
