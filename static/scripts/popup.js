/**
 * @param text {string}
 */
function showPopup(text) {
    const popup = document.createElement("p");
    popup.classList.add("popup");
    popup.innerText = text;
    document.body.append(popup);

    setTimeout(() => popup.remove(), 2000);
}
