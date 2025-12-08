function detectDarkModeFromElement(el) {
    if (!el) return false;

    // 1) data-theme on element
    const dataTheme = el.getAttribute && el.getAttribute('data-theme');
    if (dataTheme) return dataTheme === 'dark';

    // 2) explicit classes on element
    const elClassList = el.classList || [];
    if (elClassList.contains && (elClassList.contains('theme-dark') || elClassList.contains('dark') || elClassList.contains('is-dark'))) return true;
    if (elClassList.contains && (elClassList.contains('theme-light') || elClassList.contains('light') || elClassList.contains('is-light'))) return false;

    // 3) closest ancestor with data-theme or classes
    const anc = el.closest && el.closest('[data-theme], .theme-dark, .theme-light, .dark, .light, .is-dark, .is-light');
    if (anc) {
        const ancData = anc.getAttribute && anc.getAttribute('data-theme');
        if (ancData) return ancData === 'dark';
        const acl = anc.classList || [];
        if (acl.contains && (acl.contains('theme-dark') || acl.contains('dark') || acl.contains('is-dark'))) return true;
        if (acl.contains && (acl.contains('theme-light') || acl.contains('light') || acl.contains('is-light'))) return false;
    }

    // 4) fallback to body data-theme or global var
    const bodyTheme = document.body && document.body.getAttribute && document.body.getAttribute('data-theme');
    if (bodyTheme) return bodyTheme === 'dark';

    if (typeof window !== 'undefined' && window.menuColorScheme) return window.menuColorScheme === 'dark';

    return false;
}

function getMenuColors(el) {
    const isDarkMode = detectDarkModeFromElement(el);
    return {
        textColor: isDarkMode ? "rgba(255, 255, 255, 0.8)" : "rgba(0, 0, 0, 0.8)",
        textHoverColor: isDarkMode ? "rgba(255, 255, 255, 1)" : "rgba(0, 0, 0, 1)",
        bgColor: isDarkMode ? "rgba(255, 255, 255)" : "rgba(0, 0, 0)",
    };
}

export function initMenuAnimations() {
    const menuItems = document.querySelectorAll("[data-menu-item]");

    menuItems.forEach((item) => {
        // Compute colors per-item based on its classes/data attributes/ancestors
        const colors = getMenuColors(item);

        const bg = document.createElement("div");
        bg.classList.add("menu-bg");
        bg.style.position = "absolute";
        bg.style.top = "0";
        bg.style.left = "0";
        bg.style.width = "100%";
        bg.style.height = "100%";
        bg.style.backgroundColor = colors.bgColor;
        bg.style.opacity = "0";
        item.style.position = "relative";
        item.insertBefore(bg, item.firstChild);

        const label = item.querySelector("label");
        gsap.set(label, {
            color: colors.textColor,
        });

        item.addEventListener("mouseenter", () => {
            gsap.to(bg, {
                opacity: 0.3,
                duration: 0.3,
                ease: "power2.out",
            });
            gsap.to(label, {
                color: colors.textHoverColor,
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
                color: colors.textColor,
                duration: 0.3,
                ease: "power2.out",
            });
        });
    });
}
