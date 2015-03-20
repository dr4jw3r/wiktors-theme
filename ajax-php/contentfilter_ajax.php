<?php 
	$function = $_POST['function'];
	$filepath = realpath('.') . '/bwlist.txt';

	if(strtolower($function) == 'get'){

		if(!file_exists($filepath)){
			touch($filepath);
		}

		$filesize = filesize($filepath);

		if($filesize > 0){
			$list = explode(PHP_EOL, file_get_contents($filepath));

			header('Content-Type: application/json');
			echo json_encode($list);
		}
		
	}
	else if(strtolower($function) == 'save'){

		if(!file_exists($filepath)){
			touch($filepath);
		}

		$word = strtolower($_POST['word']) . PHP_EOL;

		file_put_contents($filepath, $word, FILE_APPEND | LOCK_EX) or die("Error saving to the file.");
		$list = explode(PHP_EOL, file_get_contents($filepath));

		header('Content-Type: application/json');
		echo json_encode($list);
	}
	else if(strtolower($function) == 'remove'){
		
		$list = explode(PHP_EOL, file_get_contents($filepath));
		$index = array_search($_POST['word'], $list);

		unset($list[$index]);

		$list = implode(PHP_EOL, $list);

		file_put_contents($filepath, $list, LOCK_EX) or die();

		$list = explode(PHP_EOL, file_get_contents($filepath));

		header('Content-Type: application/json');
		echo json_encode($list);
	}
?>