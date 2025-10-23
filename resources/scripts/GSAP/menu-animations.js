const MENU_TEXT_COLOR = "rgba(255, 255, 255, 0.8)";
const MENU_TEXT_HOVER_COLOR = "rgba(255, 255, 255, 1)";

export function initMenuAnimations() {
    const menuItems = document.querySelectorAll("[data-menu-item]");

    menuItems.forEach((item) => {
        const bg = document.createElement("div");
        bg.classList.add("menu-bg");
        bg.style.position = "absolute";
        bg.style.top = "0";
        bg.style.left = "0";
        bg.style.width = "100%";
        bg.style.height = "100%";
        bg.style.backgroundColor = "rgba(255,255, 255)";
        bg.style.opacity = "0";
        item.style.position = "relative";
        item.insertBefore(bg, item.firstChild);

        const label = item.querySelector("label");
        // Set initial color state
        gsap.set(label, {
            color: MENU_TEXT_COLOR,
        });

        item.addEventListener("mouseenter", () => {
            gsap.to(bg, {
                opacity: 0.3,
                duration: 0.3,
                ease: "power2.out",
            });
            gsap.to(label, {
                color: MENU_TEXT_HOVER_COLOR,
                duration: 0.3,
                ease: "power2.out",
            });
        });

        item.addEventListener("mouseleave", () => {
            gsap.to(bg, {
                opacity: 0,
                duration: 0.3,
                ease: "power2.in",
            });
            gsap.to(label, {
                color: MENU_TEXT_COLOR,
                duration: 0.3,
                ease: "power2.out",
            });
        });
    });
}
