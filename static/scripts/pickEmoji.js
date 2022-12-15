import {createPopup} from 'https://unpkg.com/@picmo/popup-picker@latest/dist/index.js?module';
import {TwemojiRenderer} from 'https://unpkg.com/@picmo/renderer-twemoji@latest/dist/index.js?module';

export const picker = createPopup({
		renderer: new TwemojiRenderer(),
		i18n: {
			"categories.activities": "Activités",
			'categories.animals-nature': 'Animaux & Nature',
			'categories.custom': 'Personnalisé',
			'categories.flags': 'Drapeaux',
			'categories.food-drink': 'Nourriture & Boissons',
			'categories.objects': 'Objets',
			'categories.people-body': 'Personnes & Corps',
			'categories.recents': 'Récents',
			'categories.smileys-emotion': 'Smileys & Émotions',
			'categories.symbols': 'Symboles',
			'categories.travel-places': 'Voyages & Lieux',
			'error.load': 'Impossible de charger les émojis',
			'recents.clear': 'Vider les récents',
			'recents.none': 'Aucun émoji récent',
			'retry': 'Réessayer',
			'search.clear': 'Effacer la recherche',
			'search.error': 'Impossible de charger les résultats',
			'search.notFound': 'Aucun émoji trouvé',
			'search': 'Rechercher',
		},
	}, {
		rootElement: document.documentElement,
		target: document.documentElement,
		onPositionLost: 'hold',
		hideOnClickOutside: false,
	}
);

picker.addEventListener('emoji:select', async event => {
	const postId = picker.referenceElement.value;
	const emoji = event.emoji;
	console.log(`/addReaction?postId=${postId}&emoji=${emoji}`);
	window.location.href = `/createReaction?postId=${postId}&emoji=${emoji}`;
});

export function pickEmoji(btn) {
	picker.toggle({
		referenceElement: btn,
		trigger: btn,
	})
}

