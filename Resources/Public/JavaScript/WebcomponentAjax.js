function customTransform(data) {
  return `<strong>Transformierte Daten:</strong> ${data.toUpperCase()}`;
}

class PorthDAjax extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: 'open' });
    this.clickCount = 0;
  }

  connectedCallback() {
    this.renderInitial();
  }

  static get observedAttributes() {
    return ['url', 'loading-text', 'error-text', 'callback', 'button-text', 'button-style', 'max-click'];
  }

  attributeChangedCallback() {
    this.renderInitial();
  }

  renderInitial() {
    const buttonText = this.getAttribute('button-text');
    const buttonStyle = this.getAttribute('button-style') || '';

    if (buttonText && buttonText.trim()) {
      this.shadowRoot.innerHTML = `
                        <button id="loadButton" style="${buttonStyle}">${buttonText}</button>
                        <div id="output" aria-live="polite"></div>
                    `;
      const button = this.shadowRoot.querySelector('#loadButton');
      button.addEventListener('click', () => {
        const maxClick = parseInt(this.getAttribute('max-click'), 10);
        this.clickCount++;
        if (!isNaN(maxClick) && this.clickCount >= maxClick) {
          button.disabled = true;
          button.style.visibility = 'hidden';
        }
        this.fetchData();
      });
    } else {
      this.fetchData();
    }
  }

  async fetchData() {
    const url = this.getAttribute('url');
    const loadingText = this.getAttribute('loading-text') || 'Lade...';
    const errorText = this.getAttribute('error-text') || 'Fehler beim Laden der Daten';
    const callback = this.getAttribute('callback');
    const output = this.shadowRoot.querySelector('#output') || this.shadowRoot;

    if (!url) {
      output.innerHTML = `<div aria-live="assertive">${errorText}</div>`;
      return;
    }

    output.innerHTML = `<div aria-live="polite">${loadingText}</div>`;

    try {
      const response = await fetch(url);
      if (!response.ok) throw new Error('net work error');
      let data = await response.text();

      if (callback && typeof window[callback] === 'function') {
        data = window[callback](data);
      }

      output.innerHTML = `<div aria-live="polite">${data}</div>`;
    } catch (error) {
      output.innerHTML = `<div aria-live="assertive">${errorText}</div>`;
    }
  }
}

customElements.define('porthd-ajax', PorthDAjax);
