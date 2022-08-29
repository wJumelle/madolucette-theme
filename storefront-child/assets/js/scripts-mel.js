window.onload = () => {
    /** 
     * Global
     */
    // Positionnement de l'image dans le footer
    if(document.querySelector('.mel-footer > .col-full') !== null) {
        const footer = document.querySelector('.mel-footer');
        const rightSpace = document.querySelector('.mel-footer > .col-full').offsetLeft;
        const topSpace = parseInt(getComputedStyle(footer).paddingTop);

        console.log({footer}, {rightSpace}, {topSpace}, footer.style.backgroundPosition);
        footer.style.backgroundPosition = `right ${rightSpace}px bottom ${topSpace}px`;
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

            btnAdd.addEventListener('click', (e) => {
                e.preventDefault();
                const button = e.target;
                const input = button.parentElement.querySelector('.qty');
                const value = parseInt(input.value);
                if(value + 1 <= parseInt(input.max)) input.value = value + 1;
                
                // On vérifie l'état des boutons
                checkBtnsStateInputNumber(button.parentElement);
            });

            btnRemove.addEventListener('click', (e) => {
                e.preventDefault();
                const button = e.target;
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
        });
    }

    // Positionnement des boutons en fonction de la hauteur de l'image
    if(document.querySelector('.single-product .woocommerce-product-gallery__wrapper img') !== null) {
        const firstGalleryImg = document.querySelector('.woocommerce-product-gallery__wrapper img');
        const summary = document.querySelector('.mel-product--summary');

        summary.style.height = firstGalleryImg.offsetHeight + 'px';
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

        console.log({footer}, {rightSpace}, {topSpace}, footer.style.backgroundPosition);
        footer.style.backgroundPosition = `right ${rightSpace}px bottom ${topSpace}px`;
    }
})

// Fonction de gestion des états des boutons de type number
function checkBtnsStateInputNumber(btnsContainer) {
    const btnAdd = btnsContainer.querySelector('.mel-gui--qty-add');
    const btnRemove = btnsContainer.querySelector('.mel-gui--qty-remove');
    const input = btnsContainer.querySelector('.qty');

    (input.value === input.max) ? btnAdd.classList.add('mel-gui--disabled') : btnAdd.classList.remove('mel-gui--disabled');
    (input.value === input.min) ? btnRemove.parentElement.querySelector('.mel-gui--qty-remove').classList.add('mel-gui--disabled') : btnRemove.parentElement.querySelector('.mel-gui--qty-remove').classList.remove('mel-gui--disabled');
}