customElements.define('research-code', class extends HTMLElement {
    async connectedCallback() {
        const { highlight } = await import('./chat-code');
        highlight(this.querySelector('code'));
    }
});
