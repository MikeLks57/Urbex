<?php $this->layout('layout', ['title' => 'Mot de passe oublié']) ?>

<?php $this->start('main_content') ?>

	<section class="login">
		Pour réinitialiser votre mot de passe, entrez votre adresse mail :
		<form action="#" method="post">
			<fieldset>
				<input type="text" name="mail" placeholder="E-mail">
			</fieldset>
			<button type="submit" name="send-mail">Envoyer un mail de réinitialisation</button>
		</form>
	</section>

<?php $this->stop('main_content') ?>