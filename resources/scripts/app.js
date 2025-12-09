/**
 * Main application entry point
 * Initializes all GSAP animations and interactions
 */

import { initMenuAnimations } from "./GSAP/menu-animations";
import { initWordmarkAnimations } from "./GSAP/wordmark-animation";
import { initInvertOnHover } from "./GSAP/invert-on-hover";
import {
    initContentFadeIn,
    initSimplePageTransitions,
} from "./GSAP/page-fade-in";

function initializeApp() {
    // Page transitions - must run first to prevent FOUC
    initContentFadeIn();
    initSimplePageTransitions();

    // Interactive animations
    initMenuAnimations();
    initWordmarkAnimations();
    initInvertOnHover();
}

// Run immediately if DOM is ready, otherwise wait for DOMContentLoaded
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initializeApp);
} else {
    initializeApp();
}
