function iconLoad(selector) {
    const element = document.querySelector(selector);
    if (!element) return;

    window.addEventListener('load', () => {
        iconReplace(element);
    });
    element.addEventListener('change', () => {
        iconReplace(element);
    });
}

function iconReplace(element) {
    const iconPreview = document.querySelector('#icon-preview');
    const currentClass = iconPreview.classList[1];
    iconPreview.classList.replace(currentClass, element.value);
}

['#hardware_icon', '#social_network_icon'].forEach(iconLoad);