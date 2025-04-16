class PorthDAjax extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: 'open' });
    this.clickCount = 0;
  }

  connectedCallback() {
      // Falls automatisch wegen fehlnden oder leeren Button-text geladen werden soll, wird die in Initial erledigt.
    this.renderInitial();
  }

  static get observedAttributes() {
    return ['url', 'loading-text', 'error-text', 'callback', 'button-text', 'button-style', 'max-click'];
  }

  attributeChangedCallback() {
    // Nur rendern, wenn das Element bereits im DOM ist
    if (!this.isConnected) return;
    this.renderInitial();
  }

  renderInitial() {
    const buttonText = (this.getAttribute('button-text') || '').trim();
    const buttonStyle = this.getAttribute('button-style') || '';

    // Nur einmal Button + Output-Bereich erzeugen, nicht immer neu überschreiben
    if (!this.shadowRoot.querySelector('#loadButton')) {
      const container = document.createElement('div');
      const button = document.createElement('button');
      button.id = 'loadButton';
      button.innerHTML = buttonText || 'Laden';
      button.style = buttonStyle;

      const output = document.createElement('div');
      output.id = 'output';
      output.setAttribute('aria-live', 'polite');

      const slot = document.createElement('slot');

      output.appendChild(slot);
      if(buttonText !== '') {
        container.appendChild(button);
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
      container.appendChild(output);
      this.shadowRoot.appendChild(container);
    }
  }

  async fetchData() {
    const output = this.shadowRoot.querySelector('#output');
    if (!output) {
      console.warn('fetchData aufgerufen, aber #output ist noch nicht vorhanden.');
      return;
    }

    const url = this.getAttribute('url');
    const loadingText = this.getAttribute('loading-text') || 'Lade...';
    const errorText = this.getAttribute('error-text') || 'Fehler beim Laden der Daten';
    const callback = this.getAttribute('callback');

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


export default PorthDAjax;
