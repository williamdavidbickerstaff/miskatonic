import { initMenuAnimations } from "./GSAP/menu-animations";
import { initWordmarkAnimations } from "./GSAP/wordmark-animation";
import { initInvertOnHover } from "./GSAP/invert-on-hover";
import { initPageFadeIn } from "./GSAP/page-fade-in"; // Add this
import { initContentFadeIn } from "./GSAP/page-fade-in";
import { initPageTransitions } from "./GSAP/page-fade-in";
import { initSimplePageTransitions } from "./GSAP/page-fade-in";

document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM loaded");

    initContentFadeIn(); // Simple whole-page fade
    initSimplePageTransitions();

    initMenuAnimations();
    initWordmarkAnimations();
    initInvertOnHover(); // targets .invert-on-hover by default
});
