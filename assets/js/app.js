import '../scss/main.scss';

HTMLElement.prototype.flash = function() {
    setTimeout(() => {
        this.classList.add("FlashBag__Message--hide")
    }, this.dataset.delay)
};

document.querySelectorAll(".FlashBag__Message").forEach(e => e.flash());
