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
	include_once './Sources/Btc/' . $class_name . '.php';
});

$prices = array();
$classes = array();

$directory = opendir('./Sources/Btc');
while (false !== ($file = readdir($directory))) {
	if (substr($file, -4) === '.php') {
		$classes[] = substr($file, 0, -4);
	}
}
closedir($directory);

if (count($classes) == 0) {
	exit("Empty classes");
}

$db->query("INSERT INTO `currency_btc_id` (`datetime`) VALUES(now())");
$id = $db->lastInsertId();

foreach ($classes as $className) {
	$class = new $className();
	$price = $class->getPrice();
	if ($price != false) {
		$prices[$class->currency][] = $price;
		try {
			$query = $db->prepare("INSERT INTO `currency_btc_log` (`id`, `amount`, `currency`, `date`, `source`) VALUES(:id, :amount, :cur, now(), :source)");
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query->bindParam(':amount', $price, PDO::PARAM_STR);
			$query->bindParam(':cur', $class->currency, PDO::PARAM_STR);
			$query->bindParam(':source', $class->source, PDO::PARAM_INT);
			$query->execute();
		} catch (Exception $e) {
			var_dump($e->getMessage());
			continue;
		}
	} else {
		var_dump($class);
	}
}

foreach (array('USD', 'EUR', 'RUB') as $val) {
	if (!empty($prices[$val])) {
		$avg = array_sum($prices[$val]) / count($prices[$val]);

		try {
			$query = $db->prepare("INSERT INTO `currency_btc` (`id`, `amount`, `currency`) VALUES(:id, :amount, :cur)");
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query->bindParam(':amount', $avg, PDO::PARAM_STR);
			$query->bindParam(':cur', $val, PDO::PARAM_STR);
			$query->execute();
		} catch (Exception $e) {
			var_dump($e->getMessage());
			continue;
		}
	}
}
