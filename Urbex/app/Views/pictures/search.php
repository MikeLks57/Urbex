<?php $this->layout('layout', ['title' => 'Recherche']) ?>

<?php $this->start('main_content') ?>
	<form action="#" method="get" accept-charset="utf-8">
		<input type="text" name="search">
		<input type="submit" name="searched">		
	</form>	


<?php if (isset($_GET['searched'])): ?>
	<table>
		<thead>
			<tr>
				<th>Titre</th>
				<th>Description</th>
				<th>Image</th>
				<th>Localisation</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($allResult as $result): ?>
				<tr>
					<td><?php echo $result['title'] ?></td>
					<td><?php echo $result['description'] ?></td>
					<td><img src="<?php echo $this->assetUrl('uploads/'.$result['url_mini']) ?>" alt="<?php echo $result['alt'] ?>"></td>
					<td><?php echo $result['gps'] ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>	
<?php endif ?>




<?php $this->stop('main_content') ?>

