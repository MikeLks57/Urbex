<?php $this->layout('layout', ['title' => 'Ajout d\'image']) ?>

<?php $this->start('main_content') ?>
	<h1>Ajout d'une photo</h1>
	<form enctype="multipart/form-data" method="POST" accept-charset="utf-8">

		Titre: 
		<input type="text" name="title"><br>
		<?php if(isset($errors['title']['empty'])) : ?>
			<p>Entrer un titre</p>
		<?php endif ?>

		Description: 
		<textarea name="description"></textarea><br>
		<?php if(isset($errors['description']['empty'])) : ?>
			<p>Entrer une description</p>
		<?php endif ?>

	    Sélectionner le fichier : 
	    <input name="my-file" type="file" /><br>
		<?php if(isset($errors['my-file'])) : ?>
			<p><?php echo $errors['my-file'] ?></p>
		<?php endif ?>

	    Emplacement géographique:
		<input type="text" name="place"><br>
		<?php if(isset($errors['place']['empty'])) : ?>
			<p>Entrer un emplacement géographique</p>
		<?php endif ?>

	    <input type="submit" name="send-file" value="Envoyer le fichier" />
	</form>	
<?php $this->stop('main_content') ?>