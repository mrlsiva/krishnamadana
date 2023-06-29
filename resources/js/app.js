import "./bootstrap";
import Alpine from "alpinejs";
import focus from "@alpinejs/focus";
import collapse from "@alpinejs/collapse";
import Swiper, { Autoplay, Navigation, Pagination } from "swiper";

Swiper.use([Navigation, Pagination, Autoplay]);
Alpine.plugin(focus);
Alpine.plugin(collapse);
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
});
