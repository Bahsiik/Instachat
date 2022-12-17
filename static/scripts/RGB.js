export default class RGB {
	constructor(r, g, b) {
		this.r = r;
		this.g = g;
		this.b = b;
	}
}

export function updateCharacterCount(text, textLengthDiv, maxLength) {
	const lengthParagraph = textLengthDiv.querySelector('span');
	lengthParagraph.innerHTML = text.length;

	if (text.length === 0) {
		textLengthDiv.style.color = 'white';
	} else {
		const half = maxLength / 2;
		const color = text.length <= half
			? new RGB(255, 255, 255 - (text.length / half) * 255)
			: new RGB(255, 255 - ((text.length - half) / half) * 255, 0);
		textLengthDiv.style.color = `rgb(${color.r}, ${color.g}, ${color.b})`;
	}
}
