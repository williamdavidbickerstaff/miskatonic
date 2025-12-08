import { initMenuAnimations } from "./GSAP/menu-animations";
import { initWordmarkAnimations } from "./GSAP/wordmark-animation";
import { initInvertOnHover } from "./GSAP/invert-on-hover";

document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM loaded");
    initMenuAnimations();
    initWordmarkAnimations();
    initInvertOnHover(); // targets .invert-on-hover by default
});
