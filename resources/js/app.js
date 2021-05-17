require('./bootstrap');
const destroyButtons = $('table form.destroy-action button[data-confirm]');
    destroyButtons.click((event) => {
    event.preventDefault();
    const $this = $(event.target);
    const $destroyButton = $this.is('button') ? $this : $this.closest('button');
    const message = $destroyButton.data('confirm');
    const form = $destroyButton.closest('form');
    if (message && confirm(message)) {
        form.submit();
    }
});
