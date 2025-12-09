/**
 * Page transition animations
 * Handles fade-in on load and fade-out on navigation
 */

import {
    TIMING,
    EASE,
    SELECTORS,
    getInternalLinks,
    shouldSkipTransition,
} from "./config.js";

/**
 * Main content fade-in with granular control
 * Prevents FOUC by hiding page until animations are ready
 */
export function initContentFadeIn() {
    // Ensure page is hidden initially
    gsap.set("html", { visibility: "hidden", opacity: 0 });
    gsap.set("body", { opacity: 0 });
    gsap.set(SELECTORS.mainContainer, { opacity: 0 });

    const tl = gsap.timeline({ immediateRender: false });

    // Reveal page
    tl.set("html", { visibility: "visible" });
    tl.to("html", {
        opacity: 1,
        duration: TIMING.normal,
        ease: EASE.out,
        immediateRender: true,
    });
    tl.to(
        "body",
        {
            opacity: 1,
            duration: TIMING.normal,
            ease: EASE.out,
            immediateRender: true,
        },
        "-=0.3"
    );

    // Fade in main container
    tl.to(
        SELECTORS.mainContainer,
        {
            opacity: 1,
            duration: TIMING.medium,
            ease: EASE.out,
        },
        "-=0.2"
    );

    // Animate wordmark elements
    tl.from(
        SELECTORS.wordmark,
        {
            opacity: 0,
            y: 20,
            duration: TIMING.slow,
            stagger: 0.1,
            ease: EASE.out,
        },
        "-=0.3"
    );

    // Animate remaining content
    tl.from(
        SELECTORS.gridContent,
        {
            opacity: 0,
            y: 15,
            duration: TIMING.slower,
            stagger: 0.08,
            ease: EASE.out,
        },
        "-=0.4"
    );
}

/**
 * Simple page transition - fade out body on navigation
 */
export function initSimplePageTransitions() {
    const internalLinks = getInternalLinks();

    internalLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            if (shouldSkipTransition(e, this)) return;

            e.preventDefault();
            const href = this.getAttribute("href");

            gsap.timeline({
                onComplete: () => {
                    gsap.set("html", { visibility: "hidden", opacity: 0 });
                    window.location.href = href;
                },
            }).to("body", {
                opacity: 0,
                duration: TIMING.medium,
                ease: EASE.in,
            });
        });
    });
}
