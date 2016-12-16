<?php

namespace Controller;

use \W\Controller\Controller;
use Service\ImageManagerService;
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

	public function add()
	{
		$PicturesModel = new PicturesModel();


		if(isset($_POST['send-file'])) {
			$errors = [];

			if(empty($_POST['title'])) {
				$errors['title']['empty'] = true;
			}
			if(empty($_POST['description'])) {
				$errors['description']['empty'] = true;
			}
			if(empty($_POST['place'])) {
				$errors['place']['empty'] = true;
			}

			// Vérifier si le téléchargement du fichier n'a pas été interrompu
			if ($_FILES['my-file']['error'] != UPLOAD_ERR_OK) {
		        // A ne pas faire en-dehors du DOM, bien sur.. En réalité on utilisera une variable intermédiaire
				$errors['my-file'] = 'Merci de choisir un fichier';
			} else {
		        // Objet FileInfo
				$finfo = new \finfo(FILEINFO_MIME_TYPE);

		        // Récupération du Mime
				$mimeType = $finfo->file($_FILES['my-file']['tmp_name']);

				$extFoundInArray = array_search(
					$mimeType, array(
						'bmp' => 'image/bmp',
						'jpg' => 'image/jpeg',
						'png' => 'image/png',
						'gif' => 'image/gif',
						)
					);
				if ($extFoundInArray === false) {
					$errors['my-file'] =  'Le fichier n\'est pas une image';
				} else {
		            // Renommer nom du fichier
					$shaFile = sha1_file($_FILES['my-file']['tmp_name']);
					$nbFiles = 0;
		            $fileName = ''; // Le nom du fichier, sans le dossier
		            do {
		            	$fileName = $shaFile . $nbFiles . '.' . $extFoundInArray;
		            	$fullPath = 'assets/img/' . $fileName;
		            	$nbFiles++;
		            } while(file_exists($fullPath));

		            $infos = getimagesize($_FILES['my-file']['tmp_name']);
		            $width = $infos[0];
		            $height = $infos[1];

		            if($width < 50 || $height < 50) {
		            	$errors['my-file'] = 'L\'image doit mesurer plus de 50px de hauteur et de largeur';
		            }

		            $size = $_FILES['my-file']['size'];
		            if($size > 10000000) {
		                // Si l'image fait plus de 10 Mo
		            	$errors['my-file'] = 'L\'image est trop lourde (plus de 10 Mo)';
		            }
		        }
		    }
	        if(count($errors) === 0) {
            	$moved = move_uploaded_file($_FILES['my-file']['tmp_name'], $fullPath);
            	
				$miniFile = new ImageManagerService();
	            $miniFile->resize($fullPath, null, 100, 0, true , 'assets/img/' .'mini.' . $fileName,  false);

			// Ajouter si OK
            	$PicturesModel->insert([
            		'title' 		=> $_POST['title'],
            		'description' 	=> $_POST['description'],
            		'url' 			=> $fileName,
            		'url_mini' 		=> 'mini.' . $fileName,
            		'alt'			=> 'image de ' . $_POST['title'],
            		'gps' 			=> $_POST['place'],
            		'id_users' 		=> 31,
            		]);
        		if (!$moved) {
                    $errors['my-file'] = 'Erreur lors de l\'enregistrement';
                }
            	$this->redirectToRoute('default_page_home');
            } else {
            	$this->show('pictures/add', ['errors' => $errors]);
            }

		} else {
			// Sinon, afficher le formulaire
			$this->show('pictures/add');
		}
	}

	public function search()
	{

		$PicturesModel = new PicturesModel();
		if (isset($_GET['searched'])) {
			$search = [
				'title' => $_GET['search'],
				'description' => $_GET['search'],
				'gps' => $_GET['search'],
			];
			$allResult = $PicturesModel->search($search, 'OR'); 
			$this->show('pictures/search', ['allResult' => $allResult,]);
		} else {
			$this->show('pictures/search');
		}
		
	}


}
