export function initWordmarkAnimations() {
    const wordmarkElements = document.querySelectorAll("[data-wordmark]");
    gsap.set(wordmarkElements, { opacity: 0 });
    gsap.to(wordmarkElements, {
        opacity: 1,
        duration: 0.5,
        stagger: 0.2,
        ease: "power2.out",
    });

    // Add text scramble effect on hover for MISKATONIC wordmark
    initWordmarkScramble();
}

// Text scrambling function - generates random characters
function generateScrambledText(originalText, chars = "MISKATONIC") {
    return originalText
        .split("")
        .map((char) => {
            // Keep spaces and special characters
            if (char === " " || /[^A-Za-z0-9]/.test(char)) {
                return char;
            }
            // Return random character from charset
            return chars[Math.floor(Math.random() * chars.length)];
        })
        .join("");
}

function initWordmarkScramble() {
    // Find all wordmark containers by looking for links that contain the MISKATONIC pattern
    const allLinks = document.querySelectorAll("a");

    const wordmarkContainers = Array.from(allLinks).filter((link) => {
        const letterGroups = link.querySelectorAll(
            "h1[data-wordmark].title-style"
        );
        // Check if we have exactly 4 groups and they match the MISKATONIC pattern
        if (letterGroups.length === 4) {
            const texts = Array.from(letterGroups).map((el) =>
                el.textContent.trim()
            );
            // Check if the first group starts with "MIS" (could be "MIS" or have extra content)
            return (
                texts[0].includes("MIS") &&
                texts[1].includes("KA") &&
                texts[2].includes("TON") &&
                texts[3].includes("IC")
            );
        }
        return false;
    });

    wordmarkContainers.forEach((container) => {
        // Find the MISKATONIC letter groups (MIS, KA, TON, IC) within this container
        const letterGroups = container.querySelectorAll(
            "h1[data-wordmark].title-style"
        );

        // Only proceed if we found exactly 4 letter groups (MIS, KA, TON, IC)
        if (letterGroups.length === 4) {
            // Store original text for each group
            const originalTexts = Array.from(letterGroups).map((el) =>
                el.textContent.trim()
            );

            let scrambleInterval = null;

            // Hover in - scramble the text
            container.addEventListener("mouseenter", () => {
                // Clear any existing interval
                if (scrambleInterval) {
                    clearInterval(scrambleInterval);
                }

                // Scramble immediately
                letterGroups.forEach((group, index) => {
                    const originalText = originalTexts[index];
                    group.textContent = generateScrambledText(originalText);
                });

                // Continue scrambling at intervals while hovering
                scrambleInterval = setInterval(() => {
                    letterGroups.forEach((group, index) => {
                        const originalText = originalTexts[index];
                        group.textContent = generateScrambledText(originalText);
                    });
                }, 80); // Update every 80ms for smooth scrambling
            });

            // Hover out - return to original text
            container.addEventListener("mouseleave", () => {
                // Clear the scrambling interval
                if (scrambleInterval) {
                    clearInterval(scrambleInterval);
                    scrambleInterval = null;
                }

                // Return to original text with a smooth reveal animation
                letterGroups.forEach((group, index) => {
                    const originalText = originalTexts[index];
                    // Use GSAP to animate the text reveal character by character
                    gsap.to(
                        {},
                        {
                            duration: 0.4,
                            onUpdate: function () {
                                const progress = this.progress();
                                const currentLength = Math.floor(
                                    originalText.length * progress
                                );
                                const revealed = originalText.substring(
                                    0,
                                    currentLength
                                );
                                const remaining =
                                    originalText.substring(currentLength);
                                const scrambled =
                                    generateScrambledText(remaining);
                                group.textContent = revealed + scrambled;
                            },
                            onComplete: () => {
                                group.textContent = originalText;
                            },
                            ease: "power2.out",
                            delay: index * 0.06, // Slight stagger for visual appeal
                        }
                    );
                });
            });
        }
    });
}

function initWordmarkJumble() {
    // Find all wordmark containers by looking for links that contain the MISKATONIC pattern
    // We'll check for links that have h1 elements with title-style and data-wordmark
    const allLinks = document.querySelectorAll("a");

    const wordmarkContainers = Array.from(allLinks).filter((link) => {
        const letterGroups = link.querySelectorAll(
            "h1[data-wordmark].title-style"
        );
        // Check if we have exactly 4 groups and they match the MISKATONIC pattern
        if (letterGroups.length === 4) {
            const texts = Array.from(letterGroups).map((el) =>
                el.textContent.trim()
            );
            // Check if the first group starts with "MIS" (could be "MIS" or have extra content)
            return (
                texts[0].includes("MIS") &&
                texts[1].includes("KA") &&
                texts[2].includes("TON") &&
                texts[3].includes("IC")
            );
        }
        return false;
    });

    wordmarkContainers.forEach((container) => {
        // Find the MISKATONIC letter groups (MIS, KA, TON, IC) within this container
        const letterGroups = container.querySelectorAll(
            "h1[data-wordmark].title-style"
        );

        // Only proceed if we found exactly 4 letter groups (MIS, KA, TON, IC)
        if (letterGroups.length === 4) {
            // Store original positions
            const originalPositions = Array.from(letterGroups).map((el) => ({
                x: 0,
                y: 0,
            }));

            // Set initial transform origin
            gsap.set(letterGroups, { transformOrigin: "center center" });

            // Hover in - jumble the letters
            container.addEventListener("mouseenter", () => {
                // Clear any existing interval
                if (container._jumbleInterval) {
                    clearInterval(container._jumbleInterval);
                }

                // Function to create a jumble cycle
                const createJumbleCycle = () => {
                    letterGroups.forEach((group, index) => {
                        // Random offset for jumbling effect
                        const randomX = (Math.random() - 0.5) * 20; // -10 to 10px
                        const randomY = (Math.random() - 0.5) * 20;
                        const randomRotation = (Math.random() - 0.5) * 10; // -5 to 5 degrees

                        gsap.to(group, {
                            x: randomX,
                            y: randomY,
                            rotation: randomRotation,
                            duration: 0.2,
                            ease: "power2.inOut",
                            delay: index * 0.03,
                        });
                    });
                };

                // Start jumbling immediately
                createJumbleCycle();

                // Continue jumbling at intervals while hovering
                const jumbleInterval = setInterval(() => {
                    createJumbleCycle();
                }, 200); // Jumble every 200ms

                // Store interval ID so we can clear it on mouse leave
                container._jumbleInterval = jumbleInterval;
            });

            // Hover out - return to normal
            container.addEventListener("mouseleave", () => {
                // Clear the jumbling interval
                if (container._jumbleInterval) {
                    clearInterval(container._jumbleInterval);
                    container._jumbleInterval = null;
                }

                // Return all letters to their original positions
                gsap.to(letterGroups, {
                    x: 0,
                    y: 0,
                    rotation: 0,
                    duration: 0.4,
                    ease: "power2.out",
                    stagger: 0.05,
                });
            });
        }
    });
}
