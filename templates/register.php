<?php $title = 'Register';
$css = ['register.css'];
$js = ['register.js'];
?>

<?php ob_start(); ?>
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form method="post" action="/index.php?create">
            <h1>Créer un compte</h1>
            <fieldset>
                <legend>Email</legend>
                <input required name="email" type="email" placeholder="Email" minlength="5" maxlength="320"/>
            </fieldset>
            <fieldset>
                <legend>Pseudo</legend>
                <input required name="username" type="text" placeholder="Pseudo" minlength="2" maxlength="20"/>
            </fieldset>
            <fieldset>
                <legend>Mot de passe</legend>
                <input required name="password" type="password" placeholder="Mot de passe" minlength="4"
                       maxlength="64"/>
            </fieldset>
            <fieldset>
                <legend>Confirmez mot de passe</legend>
                <input required name="confirm-password" type="password" placeholder="Confirmer mot de passe"
                       minlength="4"
                       maxlength="64"/>
            </fieldset>
            <fieldset>
                <legend>Genre</legend>
                <input checked type="radio" id="homme" name="gender" value="homme">
                <label for="homme">Homme</label>
                <input type="radio" id="femme" name="gender" value="femme">
                <label for="femme">Femme</label>
                <input type="radio" id="autre" name="gender" value="autre">
                <label for="autre">Autre</label>
            </fieldset>
            <fieldset>
                <legend>Naissance</legend>
                <input required type="date" id="birthdate" name="birthdate">
            </fieldset>
            <button type="submit">S'identifier</button>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form action="#">
            <h1>Se connecter</h1>
            <fieldset>
                <legend>Email</legend>
                <input required type="email" placeholder="Email" name="email" minlength="5" maxlength="320"/>
            </fieldset>
            <fieldset>
                <legend>Mot de passe</legend>
                <input required class="login-password" type="password" placeholder="Mot de passe" name="password"
                       minlength="4" maxlength="64"/>
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

