import { initMenuAnimations } from "./GSAP/menu-animations";
import { initWordmarkAnimations } from "./GSAP/wordmark-animation";
import { initInvertOnHover } from "./GSAP/invert-on-hover";
import { initPageFadeIn } from "./GSAP/page-fade-in"; // Add this
import { initContentFadeIn } from "./GSAP/page-fade-in";
import { initPageTransitions } from "./GSAP/page-fade-in";
import { initSimplePageTransitions } from "./GSAP/page-fade-in";

// Initialize fade-in as early as possible to prevent FOUC
function initializeApp() {
    console.log("DOM loaded");

    // Start fade-in immediately - this is critical to prevent flash
    initContentFadeIn();

    // Initialize other features
    initSimplePageTransitions();
    initMenuAnimations();
    initWordmarkAnimations();
    initInvertOnHover();
}

// Run immediately if DOM is ready, otherwise wait for DOMContentLoaded
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initializeApp);
} else {
    // DOM is already ready, run immediately
    initializeApp();
}
