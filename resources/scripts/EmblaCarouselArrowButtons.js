export const addPrevNextBtnsClickHandlers = (emblaApi, prevBtn, nextBtn) => {
    const scrollPrev = () => emblaApi.scrollPrev();
    const scrollNext = () => emblaApi.scrollNext();

    const togglePrevNextBtnsState = () => {
        if (emblaApi.canScrollPrev()) {
            prevBtn.removeAttribute("disabled");
        } else {
            prevBtn.setAttribute("disabled", "disabled");
        }

        if (emblaApi.canScrollNext()) {
            nextBtn.removeAttribute("disabled");
        } else {
            nextBtn.setAttribute("disabled", "disabled");
        }
    };

    prevBtn.addEventListener("click", scrollPrev, false);
    nextBtn.addEventListener("click", scrollNext, false);

    emblaApi
        .on("init", togglePrevNextBtnsState)
        .on("select", togglePrevNextBtnsState)
        .on("reInit", togglePrevNextBtnsState);

    return () => {
        prevBtn.removeEventListener("click", scrollPrev, false);
        nextBtn.removeEventListener("click", scrollNext, false);
    };
};
