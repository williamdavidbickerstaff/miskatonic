import { initMenuAnimations } from "./GSAP/menu-animations";
import { initWordmarkAnimations } from "./GSAP/wordmark-animation";

document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM loaded");
    initMenuAnimations();
    initWordmarkAnimations();
});
