<?php
declare(strict_types=1);
global $author_id, $connected_user, $id, $type;
if ($connected_user->id === $author_id) {
	?>
	<div class='post-menu'>
		<button type='submit' class='post-menu-btn action-btn'>
			<span class='material-symbols-outlined action-btn-color'>more_horiz</span>
		</button>
	</div>
	<div class='menu-container menu-hidden'>
		<button type='button' class='menu-delete-btn'>
			Supprimer
			<span class='material-symbols-outlined menu-delete-symbol'>close</span>
		</button>
		<dialog class="delete-dialog">
			<form action='/delete?type=<?= $type ?>' method='post'>
				<input type='hidden' name='<?= $type ?>_id' value="<?= $id ?>">
				<p>Êtes-vous sûr de vouloir supprimer ce <?= $type === 'comment' ? 'commentaire' : $type ?> ?</p>
				<button type="button" value="cancel" class="modal-cancel-btn">Annuler</button>
				<button type="submit" value="delete" class="modal-delete-btn">Supprimer</button>
			</form>
		</dialog>
	</div>
	<?php
}
?>