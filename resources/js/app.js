import Swiper from 'swiper';
import { Grid, Autoplay } from 'swiper/modules';


const swiper = new Swiper('.swiper', {
    modules: [Grid, Autoplay],
    slidesPerView: 2,
    grid: {
        fill: 'column',
        rows: 2,
    },
    loop: true,
    speed: 1200,
    spaceBetween: 8,
    autoplay: {
        delay: 4000,
    },
    breakpoints: {
        1024: {
            slidesPerView: 4,
            spaceBetween: 24,
            grid: {
                rows: 1,
            }
        },
    },
});

document.querySelectorAll('a[data-coupon]').forEach(link => {
    link.addEventListener('click', () => {
        const url = new URL(window.location.href)
        url.searchParams.set('cid', link.dataset.id)

        window.open(url.toString(), '_blank')
    })
});


window.trackGoal = function (goal, params = undefined) {
    if (typeof ym !== 'function') {
        return;
    }

    ym(112751477, 'reachGoal', goal, params);
}

document.querySelectorAll('a.offer').forEach((offer) => {
    offer.addEventListener('click', () => {
        console.log(offer.dataset.id);
        trackGoal('offer_click', {
            'offer_id': offer.dataset.id,
        });
    });
});


let searchStarted = false
document.querySelectorAll('input[name="shops-search"]').forEach((input) => {
    input.addEventListener('input', () => {
        if(!searchStarted) trackGoal('search_started');
        searchStarted = true;
    })
});

document.addEventListener('click', e => {
    const link = e.target.closest('.shops-search a[data-search-shop]')

    if (!link) return
    trackGoal('search_shops_click', {
        'search_shop': link.dataset.searchShop,
    });
    console.log(link.dataset.searchShop)
})
