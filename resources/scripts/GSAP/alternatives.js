/**
 * Alternative animation functions - not currently in use
 * These are kept for potential future use or reference
 */

import {
    TIMING,
    EASE,
    SELECTORS,
    findWordmarkContainers,
    getInternalLinks,
} from "./config.js";

// ============================================
// PAGE FADE ALTERNATIVES
// ============================================

/**
 * Simple page fade-in on body
 * Use when you want a basic full-page fade without granular control
 */
export function initPageFadeIn() {
    gsap.set("body", { opacity: 0 });
    gsap.to("body", {
        opacity: 1,
        duration: TIMING.slower,
        ease: EASE.out,
        delay: 0.1,
    });
}

/**
 * Fade in specific sections with stagger effect
 * Use for a more dynamic section-by-section reveal
 */
export function initSectionFadeIn() {
    const sections = document.querySelectorAll(".grid, .mx-auto > div");

    gsap.set(sections, { opacity: 0, y: 20 });
    gsap.to(sections, {
        opacity: 1,
        y: 0,
        duration: 0.8,
        stagger: 0.15,
        ease: EASE.out,
    });
}

/**
 * Detailed page transition with staggered content fade-out
 * Use when you want more elaborate exit animations
 */
export function initPageTransitions() {
    const internalLinks = getInternalLinks();

    internalLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            const href = this.getAttribute("href");

            if (
                href.startsWith("#") ||
                this.target === "_blank" ||
                e.ctrlKey ||
                e.metaKey ||
                e.shiftKey
            )
                return;

            e.preventDefault();

            const tl = gsap.timeline({
                onComplete: () => {
                    window.location.href = href;
                },
            });

            // Fade out content in reverse order
            tl.to(SELECTORS.gridContent, {
                opacity: 0,
                y: -15,
                duration: TIMING.normal,
                stagger: 0.05,
                ease: EASE.in,
            });

            tl.to(
                SELECTORS.wordmark,
                {
                    opacity: 0,
                    y: -10,
                    duration: TIMING.normal,
                    stagger: 0.05,
                    ease: EASE.in,
                },
                "-=0.2"
            );

            tl.to(
                SELECTORS.mainContainer,
                {
                    opacity: 0,
                    duration: TIMING.normal,
                    ease: EASE.in,
                },
                "-=0.2"
            );
        });
    });
}

// ============================================
// WORDMARK ALTERNATIVES
// ============================================

/**
 * Wordmark jumble effect - physically moves letter groups
 * Creates a shaking/jumbling visual effect on hover
 */
// not currently in use
export function initWordmarkJumble() {
    const wordmarkContainers = findWordmarkContainers();

    wordmarkContainers.forEach((container) => {
        const letterGroups = container.querySelectorAll(
            SELECTORS.wordmarkTitle
        );
        if (letterGroups.length !== 4) return;

        gsap.set(letterGroups, { transformOrigin: "center center" });

        container.addEventListener("mouseenter", () => {
            if (container._jumbleInterval) {
                clearInterval(container._jumbleInterval);
            }

            const createJumbleCycle = () => {
                letterGroups.forEach((group, index) => {
                    const randomX = (Math.random() - 0.5) * 20;
                    const randomY = (Math.random() - 0.5) * 20;
                    const randomRotation = (Math.random() - 0.5) * 10;

                    gsap.to(group, {
                        x: randomX,
                        y: randomY,
                        rotation: randomRotation,
                        duration: TIMING.fast,
                        ease: EASE.inOut,
                        delay: index * 0.03,
                    });
                });
            };

            createJumbleCycle();
            container._jumbleInterval = setInterval(createJumbleCycle, 200);
        });

        container.addEventListener("mouseleave", () => {
            if (container._jumbleInterval) {
                clearInterval(container._jumbleInterval);
                container._jumbleInterval = null;
            }

            gsap.to(letterGroups, {
                x: 0,
                y: 0,
                rotation: 0,
                duration: TIMING.medium,
                ease: EASE.out,
                stagger: 0.05,
            });
        });
    });
}
