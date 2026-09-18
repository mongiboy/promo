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

document.querySelectorAll('a[data-id]').forEach(link => {
    link.addEventListener('click', () => {
        const url = new URL(window.location.href)
        url.searchParams.set('cid', link.dataset.id)

        window.open(url.toString(), '_blank')
    })
})


window.trackGoal = function (goal, params = undefined) {
    if (typeof ym !== 'function') {
        return;
    }

    ym(112751477, 'reachGoal', goal, params);
}

