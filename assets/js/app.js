import '../scss/main.scss';

HTMLElement.prototype.autoresize = function() {
    let setHeight = (e) => {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight+'px';
    };

    this.addEventListener('change', setHeight);
    this.addEventListener('cut', () => setTimeout(setHeight, 0));
    this.addEventListener('paste', () => setTimeout(setHeight, 0));
    this.addEventListener('drop', () => setTimeout(setHeight, 0));
    this.addEventListener('keydown', () => setTimeout(setHeight, 0));
    this.focus();
    this.select();
    setHeight();
};

HTMLElement.prototype.flash = function() {
    setTimeout(() => {
        this.classList.add("FlashBag__Message--hide")
    }, this.dataset.delay)
};

document.querySelectorAll(".FlashBag__Message").forEach(e => e.flash());

document.querySelectorAll("textarea").forEach(e => e.autoresize());
