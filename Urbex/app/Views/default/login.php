<?php $this->layout('layout', ['title' => 'Connexion']) ?>

<?php $this->start('messages') ?>
	<?php if(isset($error)) : ?>
		<dialog open style= " text-align: center;">
			Connexion impossible <br>
			<a href="<?= $this->url('signin_signin') ?>"> => S'inscrire <= </a>
			<br>
			<a href="<?= $this->url('default_password_recovery') ?>"> => Mot de passe oublié ? <= </a>
		</dialog>
	<?php endif ?>
<?php $this->stop('messages') ?>

<?php $this->start('main_content') ?>

	<section class="login">
		<form action="#" method="post">
			<fieldset>
				<input type="text" name="mail" placeholder="E-mail">
				<input type="password" name="pass" placeholder="Mot de passe">
				<br><br>
				<?php if(isset($errors['captcha']['check'])) : ?>
					<p style= 'color : red'>Veuillez vérifier votre humanité.</p>
				<?php endif ?>
				<div class="g-recaptcha" data-sitekey="6LeX2Q4UAAAAAEnC-S8YQZpREV3oXYO9ODsVPsMv"></div>
			<br>
			</fieldset>
			<br>
			<button type="submit" name="login">Connexion</button>
		</form>
	</section>

	<?php if(isset($error['confirmed']['notconfirmed'])) : ?>
			<p style= 'color : red'>Votre compte n'a pas été confirmé !</p>
	<?php endif ?>


<?php $this->stop('main_content') ?>