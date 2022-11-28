<?php $title = 'Register';
$css = ['register.css'];
$js = ['register.js'];
?>

<?php ob_start(); ?>
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="#">
            <h1>Créer un compte</h1>
            <input type="text" placeholder="Pseudo" />
            <input type="email" placeholder="Email" />
            <input type="password" placeholder="Mot de passe" />
            <button>S'identifier</button>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form action="#">
            <h1>Se connecter</h1>
            <input type="email" placeholder="Email" />
            <input type="password" placeholder="Mot de passe" />
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
<?php require 'index.php'; ?>

