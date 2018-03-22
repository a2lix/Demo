"use strict";

document
    .querySelectorAll('form div[data-a2lix-formcollection]')
    .forEach(formCollection => {
        const addLink = document.createElement('a');
        addLink.innerHTML = 'Add entry';
        addLink.className = 'btn btn-primary btn-sm'

        formCollection.appendChild(addLink)

        const prototype = formCollection.getAttribute('data-prototype')

        addLink.addEventListener('click', evt => {
            const nbEntries = formCollection.children.length-1,
                htmlEntry = prototype.replace(/__name__label__/g, nbEntries)
                                     .replace(/__name__/g, nbEntries);

            const template = document.createElement('template');
            template.innerHTML = htmlEntry.trim();

            evt.target.parentElement.insertBefore(template.content, evt.target)
        });
    })