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
    HTMLElement.prototype.handleRemove = function () {
        this.addEventListener("click", e => {
            e.preventDefault();
            this.closest(".Collection").removeChild(e.target.closest(".Collection__Item"));
        });
    };

    document.querySelector(this.dataset.target).querySelectorAll(".Collection__Remove").forEach(e => e.handleRemove());

    this.addEventListener("click", e => {
        e.preventDefault();
        let collection = document.querySelector(this.dataset.target);
        let values = {};
        collection.querySelectorAll('input,textarea,select').forEach(field => {
            values[field.id] = {};
            if (field.attributes.type.value === "checkbox" || field.attributes.type.value === "radio") {
                values[field.id].value = field.checked;
                values[field.id].type = "choice";
            } else {
                values[field.id].value = field.value;
                values[field.id].type = "input";
            }
        });
        collection.innerHTML += collection.dataset.prototype.replace(/__name__/g, collection.dataset.index);
        for (const field in values) {
            if (values[field].type === "input") {
                collection.querySelector(`#${field}`).value = values[field].value;
            } else {
                collection.querySelector(`#${field}`).checked = values[field].value;
            }
        }
        collection.dataset.index++;
        collection.querySelectorAll(".Collection__Remove").forEach(e => e.handleRemove());
    });

};

document.querySelectorAll(".FlashBag__Message").forEach(e => e.flash());

document.querySelectorAll("textarea").forEach(e => e.autoresize());

document.querySelectorAll(".Collection__Add").forEach(e => e.handleCollection());
