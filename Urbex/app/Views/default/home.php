<?php $this->layout('layout', ['title' => 'UrbexWorld - Accueil']) ?>

<?php $this->start('main_content') ?>
	<h2>Derniers partages</h2>
	<input type="button" name="pushme" value="Push me" id="pushme">
	
	<form action="#" method="get">
		<label for="items">Photos par page</label>
    	<select name="items" id="items">
	        <option value="2">2</option>
	        <option value="3" selected>3</option>
	        <option value="5">5</option>
	        <option value="10">10</option>
    	</select>
    	<button type="submit" name="submit">Go</button>
	</form>
	<div class="row pagination up">
		<div class="col-xs-12 col-md-12">
			<p>
				<?php if($currentPage > 1) : ?>
    				<a href="<?= $this->url('pictures_getall', ['page' => $currentPage-1]) ?>">Précédent</a>
    			<?php endif ?>
    			<?php if($currentPage < $nbPages) : ?>
    				<a href="<?= $this->url('pictures_getall', ['page' => $currentPage+1]) ?>">Suivant</a>
    			<?php endif ?>
			</p>
			<?php for($i=1; $i<=$nbPages; $i++) : ?>
				<a href="<?= $this->url('pictures_getall', ['page' => $i]) ?>"><?= $i ?></a>
			<?php endfor ; ?>
		</div>
	</div>
	<?php foreach($allPictures as $pic) : ?>
		<div class="row" id="eachItem">
			<div class="eachPic col-xs-12 col-md-8 col-gauche-pic">
				<div class="row">
					<div class="eachPicture col-xs-12 col-md-12">
						<img src="<?= $this->assetUrl('img/'. $pic['url']) ?>" class="img-responsive" alt="Responsive image" width="250px" height="100px">
					</div>
					<div class="eachVote col-xs-12 col-md-12">
						<img src="<?= $this->assetUrl('img/pouceVert.png') ?>" class="img-responsive pouceVert" alt="Pouce levé" width="50px" height="50px">
					</div>
				</div>
			</div>
			<div class="eachInfos col-xs-12 col-md-4 col-droite-picInfos">
				<div class="row eachDetail">
					<div class="col-xs-12 col-md-12">
						<?= $pic['title'] ?>
					</div>
				</div>
				<div class="row eachDetail">
					<div class="col-xs-12 col-md-12">
						<?= $pic['description'] ?>
					</div>
				</div>
				<div class="row eachDetail">
					<div class="col-xs-12 col-md-12">
						<p>By <?= $pic['id_users'] ?></p>
					</div>
				</div>
			</div><!-- .picInfos -->
		</div>
	<?php endforeach ; ?>
	<div class="row pagination down">
		<div class="col-xs-12 col-md-12">
			<p>
				<?php if($currentPage > 1) : ?>
    				<a href="<?= $this->url('pictures_getall', ['page' => $currentPage-1]) ?>">Précédent</a>
    			<?php endif ?>
    			<?php if($currentPage < $nbPages) : ?>
    				<a href="<?= $this->url('pictures_getall', ['page' => $currentPage+1]) ?>">Suivant</a>
    			<?php endif ?>
			</p>
			<?php for($i=1; $i<=$nbPages; $i++) : ?>
				<a href="<?= $this->url('pictures_getall', ['page' => $i]) ?>"><?= $i ?></a>
			<?php endfor ; ?>
		</div>
	</div>
<?php $this->stop('main_content') ?>
