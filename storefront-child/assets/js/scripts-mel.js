let gridGlobalWidth = 0;
let gridGutter = 0;

window.onload = () => {
    /** 
     * Global
     */
    // Positionnement de l'image dans le footer
    if(document.querySelector('.mel-footer > .col-full') !== null) {
        const footer = document.querySelector('.mel-footer');
        const rightSpace = document.querySelector('.mel-footer > .col-full').offsetLeft;
        const topSpace = parseInt(getComputedStyle(footer).paddingTop);
        const backgroundSize = parseInt(window.getComputedStyle(footer, null).getPropertyValue('background-size'));

        if(backgroundSize > (footer.offsetHeight - topSpace)) {
            footer.style.backgroundSize = `${footer.offsetHeight - topSpace}px`;
            footer.style.backgroundPosition = `right ${rightSpace}px center`;
        } else {
            footer.style.backgroundPosition = `right ${rightSpace}px center`;
        }
    }
    // Calcul de la variable pour le calcule de la taille de la grille
    let r = document.querySelector(':root');
    r.style.setProperty('--grid-global-width', document.querySelector('#content > .col-full').offsetWidth + 'px');

    // Positionnement du texte du carrousel
    if(document.querySelector('.mel-carrousel') !== null) {
        r.style.setProperty('--space-left', document.querySelector('.mel-header > .col-full').offsetLeft + 'px');
    }

    /**
     * Home
     */
    // Positionnemenet de l'image dans la hero banner
    if(document.querySelector('.page-template-template-homepage .mel-hero .wp-block-cover__background') !== null) {
        const bkg = document.querySelector('.page-template-template-homepage .mel-hero .wp-block-cover__background');
        const posRight = document.querySelector('.page-template-template-homepage .mel-hero .wp-block-cover__inner-container').offsetLeft;
        bkg.style.backgroundPosition = `bottom right ${posRight}px`;
    }

    // Instagram Feed
    if(document.querySelector('.mel-team--instagram-feed') !== null) {
        const feedContainer = document.querySelector('.mel-team--instagram-feed');
        feedContainer.innerHTML += `<span class="mel-loader" aria-label="En cours de chargement"></span>`;

        /**
         * ToDo Chargement du feed instagram
         */
    }

    /**
     * Page produit / Page Catégories
     */
    // Ajout des boutons + et - autour des inputs number woocommerce
    if(document.querySelectorAll('input[type=number].qty').length > 0) {
        document.querySelectorAll('input[type=number].qty').forEach((e) => {
            const parent = e.parentElement;
            const btnAdd = document.createElement('button');
            btnAdd.classList.add('mel-gui--qty', 'mel-gui--qty-add');
            btnAdd.innerText = '+';
            const btnRemove = document.createElement('button');
            btnRemove.classList.add('mel-gui--qty', 'mel-gui--qty-remove');
            btnRemove.innerText = '-';

            btnAdd.addEventListener('click', (ev) => {
                ev.preventDefault();
                const button = ev.target;
                const input = button.parentElement.querySelector('.qty');
                const value = parseInt(input.value);
                if(value + 1 <= parseInt(input.max)) input.value = value + 1;
                
                // On vérifie l'état des boutons
                checkBtnsStateInputNumber(button.parentElement);
            });

            btnRemove.addEventListener('click', (ev) => {
                ev.preventDefault();
                const button = ev.target;
                const input = button.parentElement.querySelector('.qty');
                const value = parseInt(input.value);
                if(value - 1 >= parseInt(input.min)) input.value = value - 1;
                
                // On vérifie l'état des boutons
                checkBtnsStateInputNumber(button.parentElement);
            });

            parent.prepend(btnRemove);
            parent.append(btnAdd);

            // On initialise l'état des boutons
            checkBtnsStateInputNumber(parent);

            // On ajoute l'écouteur d'événement pour éviter la saisie de nombre > max dans l'input
            e.addEventListener('change', (ev) => {
                if(ev.target.valueAsNumber > parseInt(ev.target.max)) ev.target.value = ev.target.max;
                if(ev.target.valueAsNumber < parseInt(ev.target.min)) ev.target.value = ev.target.min;
            });
        });
    }

    // Positionnement des boutons en fonction de la hauteur de l'image
    if(document.querySelector('.single-product .woocommerce-product-gallery__wrapper img') !== null && window.innerWidth >= 1024) {
        const firstGalleryImg = document.querySelector('.woocommerce-product-gallery__wrapper img');
        const summary = document.querySelector('.mel-product--summary');

        summary.style.height = firstGalleryImg.offsetHeight + 'px';
    }

    /**
     * Page Catalogue
     */
    if(document.querySelector('.mel-catalogue--navigation') !== null) {
        const navigation_buttons = document.querySelectorAll('.mel-catalogue--navigation button');

        navigation_buttons.forEach((e) => {
            e.addEventListener('click', (ev) => {
                // On vérifie si le bouton n'est pas celui de la page courrante
                if(!ev.target.classList.contains('is-current')) {
                    // On affiche la bonne page
                    const nbPageToTarget = ev.target.dataset['targetedpage'];
                    const pageToTarget = document.querySelector(`.mel-category--products-list[data-page="${nbPageToTarget}"]`);
                    const actualPage = document.querySelector('.mel-category--products-list.is-current');
                    actualPage.classList.remove('is-current');
                    actualPage.classList.add('is-not-current');
                    pageToTarget.classList.remove('is-not-current');
                    pageToTarget.classList.add('is-current');

                    // On met à jour la navigation
                    const actualButton = document.querySelector('.mel-catalogue--navigation button.is-current');
                    actualButton.classList.remove('is-current')
                    actualButton.removeAttribute('aria-current');
                    actualButton.classList.add('is-not-current');
                    ev.target.classList.remove('is-not-current');
                    ev.target.classList.add('is-current');
                    ev.target.setAttribute('aria-current', 'page');

                    // On met le focus sur le premier article
                    document.querySelector('.mel-category--products-list.is-current a').focus();
                }
            });
        });
    }

    /**
     * Page contact
     */
    // Ajout d'un écouteur d'événement afin de faire apparaitre le message de confirmation d'envoi du formulaire charté
    if(document.querySelector('.wpcf7') !== null) {
        const form = document.querySelector('.wpcf7');

        // On supprime les éléments du formulaire qui n'ont plus lieu d'être et on ajoute la classe valid au msg d'erreur
        form.addEventListener('wpcf7mailsent', () => {
            if(document.querySelector('.wpcf7-response-output') !== null) document.querySelector('.wpcf7-response-output').classList.add('is-sended');
            if(document.querySelector('.mel-contact--outer-container') !== null) document.querySelector('.mel-contact--outer-container').remove();
            if(document.querySelector('.mel-contact-form--submit-container') !== null) document.querySelector('.mel-contact-form--submit-container').remove();
        });
    }

    /**
     * Page Galerie
     */
    if(document.querySelector('.page-template-template-gallery') !== null) {
        // On calcul la taille des colonnes
        gridGutter = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--grid-gutter'));
        const msnryColumnWidth = (gridGlobalWidth - (gridGutter * 2)) / 3;

        // On récupère le container et initialise masonry
        const gridContainer = document.querySelector('.mel-gallery--masonry');
        const msnry = new Masonry( gridContainer, {
            itemSelector: '.wp-block-image',
            columnWidth: msnryColumnWidth,
            gutter: gridGutter
        });
    }
}

window.addEventListener('resize', () => {
    /** 
     * Global
     */
    // Positionnement de l'image dans le footer
    if(document.querySelector('.mel-footer > .col-full') !== null) {
        const footer = document.querySelector('.mel-footer');
        const rightSpace = document.querySelector('.mel-footer > .col-full').offsetLeft;
        const topSpace = parseInt(getComputedStyle(footer).paddingTop);

        footer.style.backgroundPosition = `right ${rightSpace}px bottom ${topSpace}px`;
    };
    // Calcul de la variable pour le calcule de la taille de la grille
    let r = document.querySelector(':root');
    r.style.setProperty('--grid-global-width', document.querySelector('#content > .col-full').offsetWidth + 'px');

    /**
     * Home
     */
    // Positionnemenet de l'image dans la hero banner
    if(document.querySelector('.page-template-template-homepage .mel-hero .wp-block-cover__background') !== null) {
        const bkg = document.querySelector('.page-template-template-homepage .mel-hero .wp-block-cover__background');
        const posRight = document.querySelector('.page-template-template-homepage .mel-hero .wp-block-cover__inner-container').offsetLeft;
        bkg.style.backgroundPosition = `bottom right ${posRight}px`;
    }

    /**
     * Page Galerie
     */
    if(document.querySelector('.page-template-template-gallery') !== null) {
        // On calcul la taille des colonnes
        gridGutter = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--grid-gutter'));
        const msnryColumnWidth = (gridGlobalWidth - (gridGutter * 2)) / 3;

        // On récupère le container et initialise masonry
        const gridContainer = document.querySelector('.mel-gallery--masonry');
        msnry.destroy();
        msnry = new Masonry( gridContainer, {
            itemSelector: '.wp-block-image',
            columnWidth: msnryColumnWidth,
            gutter: gridGutter
        });
    }
})

// Fonction de gestion des états des boutons de type number
function checkBtnsStateInputNumber(btnsContainer) {
    const btnAdd = btnsContainer.querySelector('.mel-gui--qty-add');
    const btnRemove = btnsContainer.querySelector('.mel-gui--qty-remove');
    const input = btnsContainer.querySelector('.qty');

    (input.value === input.max) ? btnAdd.classList.add('mel-gui--disabled') : btnAdd.classList.remove('mel-gui--disabled');
    (input.value === input.min) ? btnRemove.parentElement.querySelector('.mel-gui--qty-remove').classList.add('mel-gui--disabled') : btnRemove.parentElement.querySelector('.mel-gui--qty-remove').classList.remove('mel-gui--disabled');

    if (input.value === input.max && input.value === input.min) btnsContainer.classList.add('mel-gui--disabled');
}