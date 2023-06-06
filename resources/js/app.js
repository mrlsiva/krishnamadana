import "./bootstrap";
import Alpine from "alpinejs";
import focus from '@alpinejs/focus'
import Swiper from "swiper";

Alpine.plugin(focus);
window.Alpine = Alpine;
window.Swiper = Swiper;

Alpine.start();

var homecarousel = new Swiper(".swiper", {
    loop: true,
    speed: 500,
    direction: "horizontal",
    autoplay: {
        delay: 3000,
    },
    effect: "fade",
    fadeEffect: {
        crossFade: true,
    },
    init: true,
    pagination: {
        el: ".swiper-pagination",
    },
});
