<?php
	session_start();
	@define ( 'LIBRARIES' , './libraries/');

	include_once LIBRARIES."config.php";	
	$d = new database($config['database']);	

	$arr_column = ['ten_cn','photo_cn','mota_cn','noidung_cn','thumb_cn','diachi_cn','slogan_cn'];

	$d->reset();
	$d->query("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_SCHEMA='".$config['database']['database']."'");
	$tables=$d->result_array();

	foreach ($tables as $key => $value) {
		$d->reset();
		$d->query("select *  from information_schema.columns  where table_schema = '".$config['database']['database']."'  and table_name = '".$value['TABLE_NAME']."'");
		$columns=$d->result_array();
		
		for ($i=0; $i < count($columns); $i++) { 
			$column_name = set_name_column($columns[$i]['COLUMN_NAME']);

			if(in_array($columns[$i]['COLUMN_NAME'],$arr_column)){
				if($columns[$i]['DATA_TYPE']=='varchar'){
					$sql="ALTER TABLE `".$value['TABLE_NAME']."` CHANGE `".$columns[$i]['COLUMN_NAME']."` `".$column_name."` VARCHAR(".$columns[$i]['CHARACTER_MAXIMUM_LENGTH'].") CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL";
				}else{
					$sql="ALTER TABLE `".$value['TABLE_NAME']."` CHANGE `".$columns[$i]['COLUMN_NAME']."` `".$column_name."` ".$columns[$i]['DATA_TYPE']." CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL";
				}
				$d->query($sql);
			}
		}
		
		echo $value['TABLE_NAME'].'<br />';
	}
	

	function set_name_column($column_name){
		switch ($column_name) {
			case 'ten_cn':
				$name = 'ten_jp';
				break;
			case 'mota_cn':
				$name = 'mota_jp';
				break;
			case 'noidung_cn':
				$name = 'noidung_jp';
				break;
			case 'diachi_cn':
				$name = 'diachi_jp';
				break;
			case 'slogan_cn':
				$name = 'slogan_jp';
				break;
			case 'photo_cn':
				$name = 'photo_jp';
				break;
			case 'thumb_cn':
				$name = 'thumb_jp';
				break;
		}
		return $name;
	}

	
 ?>