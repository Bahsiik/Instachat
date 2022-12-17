<?php
declare(strict_types=1);

$title = 'Register';
$css = ['register.css'];
$js = ['register.js'];
global $login_error, $register_error;
$has_register_error = isset($register_error);

ob_start();
?>
	<main class="container<?= $has_register_error ? ' right-panel-active' : '' ?>" id="container">
		<div class="form-container sign-up-container">
			<form action="/create-user" method="post">
				<h1>Créer un compte</h1>
				<label>Email
					<input autocomplete='new-email' maxlength="320" minlength="5" name="email" placeholder="Email" required type="email"/>
				</label>

				<label>Pseudo
					<input
						autocomplete="new-username"
						maxlength="20"
						minlength="2"
						name="username"
						placeholder="Pseudo"
						required
						type="text"
						pattern="[a-zA-Z0-9_]{2,20}"
					/>
				</label>

				<label>Mot de passe
					<input autocomplete="new-password" maxlength="64" minlength="4" name="password" placeholder="Mot de passe" required type="password"/>
				</label>

				<label>Confirmez mot de passe
					<input
						autocomplete="new-password"
						maxlength="64"
						minlength="4"
						name="confirm-password"
						placeholder="Confirmer mot de passe"
						required
						type="password"
					/>
				</label>

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
				<span class='error'><?= $register_error ?></span>
			</form>
		</div>
		<div class="form-container sign-in-container">
			<form action="/login" method="post">
				<h1>Se connecter</h1>
				<label>Email ou pseudo
					<input autocomplete="email username" maxlength="320" minlength="2" name="email" placeholder="Email ou pseudo" required type="text"/>
				</label>
				<label>Mot de passe
					<input
						autocomplete="current-password"
						class="login-password"
						maxlength="64"
						minlength="4"
						name="password"
						placeholder="Mot de passe"
						required
						type="password"
					/>
				</label>
				<button>Se connecter</button>
				<span class="error"><?= $login_error ?></span>
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
	</main>
<?php
$content = ob_get_clean();
require_once 'layout.php';
