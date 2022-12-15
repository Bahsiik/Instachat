import {globalConfig} from 'https://unpkg.com/picmo@latest/dist/index.js';
// noinspection ES6UnusedImports
import {createPopup, PopupPickerController} from 'https://unpkg.com/@picmo/popup-picker@latest/dist/index.js?module';

/**
 * @type {PopupPickerController}
 */
let picker;
globalConfig.injectStyles = false;

async function getPicker() {
	if (picker) return picker;
	const {TwemojiRenderer: twemojiRenderer} = await import('https://unpkg.com/@picmo/renderer-twemoji@latest/dist/index.js?module', {type: 'module'});
	picker = createPopup({
			renderer: new twemojiRenderer('png'),
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
		window.location.href = `/create-reaction?post-id=${postId}&emoji=${emoji}`;
	});

	return picker;
}

export async function pickEmoji(btn) {
	await (await getPicker()).open({
		referenceElement: btn,
		trigger: btn,
	})
}
