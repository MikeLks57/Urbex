<?php

namespace Model;

use W\Model\Model;
use W\Model\ConnectionModel;

class PicturesModel extends Model
{
	public function getNbPictures()
	{
		$pdo = ConnectionModel::getDbh();
		$sql = 'SELECT COUNT(*) AS nbPictures FROM ' . $this->table;
    	$result = $pdo->query($sql);
    	$row = $result->fetch();
    	return $row['nbPictures'];
	}
}