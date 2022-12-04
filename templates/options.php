<?php
$title = 'Options';
$css[] = 'options.css';

ob_start();
global $connected_user;
require_once('toolbar.php');
?>
	<div class="options">
		<div class="title">
			<h1>Paramètres</h1>
		</div>

		<div class="options-container">
			<?php
			$options = [
				'Informations du compte' => 'Afficher les informations de votre compte, comme votre numéro de téléphone et votre adresse email.',
				'Changer de mot de passe' => 'Changer de mot de passe à tout moment.',
				'Masquer et bloquer' => 'Gérer les comptes et mots que vous avez bloqués ou masqués.',
				'Affichage' => "Gérer la taille de police et l'arrière-plan.",
				'Ressources supplémentaires' => 'Informations utiles sur les divers produits du service Instachat.',
			];

			foreach ($options as $option => $description) { ?>
				<div class="option">
					<div class="option-title">
						<h2><?= $option ?></h2>
						<p class="subtitle"><?= $description ?></p>
					</div>
					<span class="material-symbols-outlined arrow">navigate_next</span>
				</div>
			<?php } ?>

			<div class="option">
				<div class="option-title">
					<h2 class="danger">Supprimer le compte</h2>
				</div>
			</div>
		</div>
	</div>
<?php
$content = ob_get_clean();
require_once('layout.php');
