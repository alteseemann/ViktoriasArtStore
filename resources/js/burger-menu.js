function burgerMenu(selector) {
    let menu = $(selector);
    let button = menu.find('.burger-menu__button');
    let links = menu.find('.burger-menu__link');
    let overlay = menu.find('.burger-menu__overlay');
    let cont = document.getElementById('main_content');

    button.on('click', (e) => {
        e.preventDefault();
        toggleMenu();
    });

    links.on('click', () => toggleMenu());
    overlay.on('mouseover', () => toggleMenu());

    function toggleMenu() {
        menu.toggleClass('burger-menu_active');
        if (cont.className === 'content') {
            cont.className += ' bm';
        } else {
            cont.className = 'content';
        }
        if (menu.hasClass('burger-menu_active')) {
            $('body').css('overflow', 'hidden');
            console.log(app.style.marginLeft)

        } else {
            $('body').css('overflow', 'visible');
        }
    }
}

burgerMenu ('.burger-menu');

