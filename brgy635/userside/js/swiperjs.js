new Swiper('.slider-wrapper', {
    loop: true,
    grabCursor: true,
    spaceBetween: 20,
    
    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true
    },
    
    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    breakpoints: {
        320:{
            slidesPerView: 1
        },
        425:{
            slidesPerView: 2
        },
        620:{
            slidesPerView: 3
        },
        1200:{
            slidesPerView: 4
        }

    }
    
});