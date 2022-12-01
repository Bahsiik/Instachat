<?php $title = 'Register';
$css = ['register.css'];
$js = ['register.js'];
?>

<?php ob_start(); ?>
<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="/index.php?create" method="post">
			<h1>Créer un compte</h1>
			<fieldset>
				<legend>Email</legend>
				<input maxlength="320" minlength="5" name="email" placeholder="Email" required type="email"/>
			</fieldset>
			<fieldset>
				<legend>Pseudo</legend>
				<input maxlength="20" minlength="2" name="username" placeholder="Pseudo" required type="text"/>
			</fieldset>
			<fieldset>
				<legend>Mot de passe</legend>
				<input
					required name="password" type="password" placeholder="Mot de passe" minlength="4"
					maxlength="64"
				/>
			</fieldset>
			<fieldset>
				<legend>Confirmez mot de passe</legend>
				<input maxlength="64" minlength="4" name="confirm-password" placeholder="Confirmer mot de passe" required type="password"/>
			</fieldset>
			<fieldset class="padding">
				<legend>Genre</legend>
				<label for="homme">Homme
					<input checked id="homme" name="gender" type="radio" value="homme">
				</label>
				<label for="femme">Femme
					<input id="femme" name="gender" type="radio" value="femme">
				</label>
				<label for="autre">Autre
					<input id="autre" name="gender" type="radio" value="autre">
				</label>
			</fieldset>
			<fieldset class="padding">
                <legend>Naissance</legend>
                <input id="birthdate" name="birthdate" required type="date">
            </fieldset>
            <button type="submit">S'identifier</button>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form action="/index.php?login" method="post">
            <h1>Se connecter</h1>
            <fieldset>
                <legend>Email ou pseudo</legend>
                <input maxlength="320" minlength="2" name="email" placeholder="Email ou pseudo" required/>
            </fieldset>
            <fieldset>
                <legend>Mot de passe</legend>
                <input class="login-password" maxlength="64" minlength="4" name="password" placeholder="Mot de passe"
                       required type="password"/>
            </fieldset>
            <button>Se connecter</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Re-bonjour !</h1>
				<p>Pour vous connecter, entrez vos identifiants ici</p>
				<button class="ghost" id="signIn">Se connecter</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Bienvenue !</h1>
				<p>Démarrez votre aventure, créez votre compte ici</p>
				<button class="ghost" id="signUp">S'identifier</button>
			</div>
		</div>
	</div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require_once('layout.php'); ?>

