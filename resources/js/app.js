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
