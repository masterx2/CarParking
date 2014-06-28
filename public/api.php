<?php
include '../classes/db.php';
/**
* CarParking Database API interface
*/
class App extends Db {
	public function getOptions() {
		$this->options = [];
		$options_cursor = $this->db->getAll('select param_name, value from options');
		$options = [];
		foreach ($options_cursor as $row) {
			$this->options[$row['param_name']] = $row['value'];
		};
	}
	
	public function getAllData() {
		$this->getOptions();
		$out = ['options' => $this->options,
				'cars' => $this->getAllCars(),
				'owners' => 'no-data'
			   ];
		$this->jsonOut($out);
	}

	public function getAllCars() {
		$cars_cursor = $this->db->getAll('select id, parkplace, owner_id, credit, unix_timestamp(ctime), description from parking');
		$cars = []; foreach ($cars_cursor as $row) { $cars[] = $row;};
		return $cars;
	}
	
	public function jsonOut($data) {
		if (isset($data)) {
			print json_encode($data);
		} else {
			throw new Exception("No Results to render!", 1);
		}
	}
}

$app = new App();
$app->getOptions();

if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'getall':
			$app->getAllData();
			break;
		default:
			print "API Method ["
				.$_POST['action']
				."] Not Found!";
			break;
	}
} else {
	print 'Invalid Request!';
}