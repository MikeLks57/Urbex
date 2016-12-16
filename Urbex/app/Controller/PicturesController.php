<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\PicturesModel;

class PicturesController extends Controller
{
	private $picturesModel;

	public function __construct() {
		$this->picturesModel = new PicturesModel();
	}

	public function getAllPictures($page=1, $nbItems=2)
	{
		$nbMax = (int)$nbItems;
		$offset = ($page - 1) * $nbMax;
		$allPictures = $this->picturesModel->findAll('id', 'DESC', $nbMax, $offset);
		$this->show('default/home', ['allPictures' => $allPictures, 'nbPages' => $this->getNbPages($nbMax), 'currentPage' => $this->getPage($page)]);
	}

	/*Calcule le nombre de pages en fonction du nombre d'items par page*/
	private function getNbPages($nbItems)
	{
		$nbPictures = $this->picturesModel->getNbPictures();
		$nbPages = ceil($nbPictures / $nbItems);
		return $nbPages;
	}

	/*Retourne le numéro de page actuelle*/
	private function getPage($page)
	{
		return $page;
	}


}
