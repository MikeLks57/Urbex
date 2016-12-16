<?php $this->layout('layout', ['title' => 'Accueil']) ?>

<?php $this->start('main_content') ?>

	<nav>
		<?php if(isset($_SESSION['user'])) : ?>
			<a href="<?= $this->url('default_logout') ?>">Déconnexion</a>
		<?php endif ?>
	</nav>

	<h2>Let's code.</h2>
	<p>Vous avez atteint la page d'accueil. Bravo.</p>
	<p>Et maintenant, RTFM dans <strong><a href="../docs/tuto/" title="Documentation de W">docs/tuto</a></strong>.</p>
<?php $this->stop('main_content') ?>
