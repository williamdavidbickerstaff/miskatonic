/**
 * Wordmark animations - handles the MISKATONIC logo effects
 */

import { TIMING, EASE, SELECTORS, findWordmarkContainers } from "./config.js";

const SCRAMBLE_CHARS = "MISKATONIC";
const SCRAMBLE_INTERVAL_MS = 80;

/**
 * Initialize wordmark fade-in and scramble effects
 */
export function initWordmarkAnimations() {
    const wordmarkElements = document.querySelectorAll(SELECTORS.wordmark);

    gsap.set(wordmarkElements, { opacity: 0 });
    gsap.to(wordmarkElements, {
        opacity: 1,
        duration: TIMING.slow,
        stagger: 0.2,
        ease: EASE.out,
    });

    initWordmarkScramble();
}

/**
 * Generate scrambled text from original
 * @param {string} text - Original text
 * @param {string} chars - Character set to use for scrambling
 * @returns {string} Scrambled text
 */
function generateScrambledText(text, chars = SCRAMBLE_CHARS) {
    return text
        .split("")
        .map((char) => {
            if (char === " " || /[^A-Za-z0-9]/.test(char)) return char;
            return chars[Math.floor(Math.random() * chars.length)];
        })
        .join("");
}

/**
 * Initialize text scramble effect on wordmark hover
 */
function initWordmarkScramble() {
    const containers = findWordmarkContainers();

    containers.forEach((container) => {
        const letterGroups = container.querySelectorAll(
            SELECTORS.wordmarkTitle
        );
        if (letterGroups.length !== 4) return;

        const originalTexts = Array.from(letterGroups).map((el) =>
            el.textContent.trim()
        );

        let scrambleInterval = null;

        container.addEventListener("mouseenter", () => {
            if (scrambleInterval) clearInterval(scrambleInterval);

            // Scramble immediately
            letterGroups.forEach((group, i) => {
                group.textContent = generateScrambledText(originalTexts[i]);
            });

            // Continue scrambling while hovering
            scrambleInterval = setInterval(() => {
                letterGroups.forEach((group, i) => {
                    group.textContent = generateScrambledText(originalTexts[i]);
                });
            }, SCRAMBLE_INTERVAL_MS);
        });

        container.addEventListener("mouseleave", () => {
            if (scrambleInterval) {
                clearInterval(scrambleInterval);
                scrambleInterval = null;
            }

            // Reveal original text with animation
            letterGroups.forEach((group, index) => {
                const original = originalTexts[index];

                gsap.to(
                    {},
                    {
                        duration: TIMING.medium,
                        ease: EASE.out,
                        delay: index * 0.06,
                        onUpdate: function () {
                            const progress = this.progress();
                            const revealLength = Math.floor(
                                original.length * progress
                            );
                            const revealed = original.substring(
                                0,
                                revealLength
                            );
                            const remaining = original.substring(revealLength);
                            group.textContent =
                                revealed + generateScrambledText(remaining);
                        },
                        onComplete: () => {
                            group.textContent = original;
                        },
                    }
                );
            });
        });
    });
}
