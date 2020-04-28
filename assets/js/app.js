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

HTMLElement.prototype.handleCollection = function() {
    let collection = document.querySelector(this.dataset.target);

    HTMLElement.prototype.handleRemove = function () {
        this.addEventListener("click", e => {
            e.preventDefault();
            collection.removeChild(e.target.closest(".Collection__Item"));
        });
    };

    collection.querySelectorAll(".Collection__Remove").forEach(e => e.handleRemove());

    this.addEventListener("click", e => {
        e.preventDefault();
        collection.innerHTML += collection.dataset.prototype.replace(/__name__/g, collection.dataset.index);
        collection.dataset.index++;
        collection.querySelectorAll(".Collection__Remove").forEach(e => e.handleRemove());
    });

};

document.querySelectorAll(".FlashBag__Message").forEach(e => e.flash());

document.querySelectorAll("textarea").forEach(e => e.autoresize());

document.querySelectorAll(".Collection__Add").forEach(e => e.handleCollection());
