import Choices from "choices.js";

const choicesSingle = document.querySelectorAll(".choices-single");

choicesSingle.forEach(function (element) {
    const choices = new Choices(element, {
        removeItemButton: true,
        duplicateItemsAllowed: false,
        delimiter: ', ',
        placeholder: true,
        placeholderValue: "Ajouter un élément",
        addItemText: (value) => {
            return `Pressez la touche Entrée pour ajouter <bol>"${value}"</bol>`;
        },
        uniqueItemText: 'Cet élément existe déjà.'
    });
});