window.onload = () => {
    /**
     * Page produit / Page Catégories
     */
    // Ajout des boutons + et - autour des inputs number woocommerce*
    console.log('Wesh', document.querySelectorAll('.input[type=number].qty'));
    if(document.querySelectorAll('input[type=number].qty').length > 0) {
        console.log('Hello');
        document.querySelectorAll('input[type=number].qty').forEach((e) => {
            console.log('there');
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
}

// Fonction de gestion des états des boutons de type number
function checkBtnsStateInputNumber(btnsContainer) {
    const btnAdd = btnsContainer.querySelector('.mel-gui--qty-add');
    const btnRemove = btnsContainer.querySelector('.mel-gui--qty-remove');
    const input = btnsContainer.querySelector('.qty');

    (input.value === input.max) ? btnAdd.classList.add('mel-gui--disabled') : btnAdd.classList.remove('mel-gui--disabled');
    (input.value === input.min) ? btnRemove.parentElement.querySelector('.mel-gui--qty-remove').classList.add('mel-gui--disabled') : btnRemove.parentElement.querySelector('.mel-gui--qty-remove').classList.remove('mel-gui--disabled');
}