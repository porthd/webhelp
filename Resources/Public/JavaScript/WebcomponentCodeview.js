class PorthDCodeView extends HTMLElement {
  async connectedCallback() {
    // Standardwerte für Attribute
    const lang = this.getAttribute('language') || 'markup';
    let theme = this.getAttribute('theme') || 'light'; // Standard-Theme ist "light"
    const showLines = this.hasAttribute('line-numbers');
    const buttonLabel = this.getAttribute('button-label') || 'Copy';
    const themeToggleLabel = this.getAttribute('theme-button-label') || 'Toggle Theme';
    const cdnBase = this.getAttribute('cdn') || 'https://cdn.jsdelivr.net/npm/prismjs';

    // Erzeuge ein Shadow-DOM
    const shadow = this.attachShadow({ mode: 'open' });

    // Hilfsfunktionen zum Laden von CSS und Javascript
    const loadCSS = href =>
      new Promise(resolve => {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = href;
        link.onload = resolve; // Warten, bis das CSS vollständig geladen wurde
        shadow.appendChild(link);
      });

    const loadScript = src =>
      new Promise(resolve => {
        const script = document.createElement('script');
        script.src = src;
        script.onload = resolve;
        document.head.appendChild(script); // Skripte werden global geladen
      });

    // Lade Prism.js und Plugins, falls nicht bereits vorhanden
    if (typeof Prism === 'undefined') {
      // Prism.js und wichtige Plugins laden
      await loadScript(`${cdnBase}/prism.js`);
      await loadScript(`${cdnBase}/plugins/line-numbers/prism-line-numbers.min.js`);
      await Promise.all(
        ['markup', 'javascript', 'css'].map(lang =>
          loadScript(`${cdnBase}/components/prism-${lang}.min.js`)
        )
      );
    }

    // Lade das passende Theme-CSS vor der Syntax-Hervorhebung
    const applyTheme = async theme => {
      const themeHref =
        theme === 'dark'
          ? `${cdnBase}/themes/prism-okaidia.css`
          : `${cdnBase}/themes/prism.css`;
      await loadCSS(themeHref); // Warten, bis CSS geladen ist
    };

    // Baue das interne HTML im Shadow DOM
    shadow.innerHTML = `
            <style>
                :host {
                    display: block;
                    position: relative;
                }
                button {
                    position: absolute;
                    top: 0.5em;
                    right: 0.5em;
                    margin: 0 0.5em;
                    z-index: 1;
                    padding: 0.5em 1em;
                    cursor: pointer;
                }
                pre {
                    margin: 0;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    overflow: auto;
                }
            </style>
            <button class="theme-toggle">${themeToggleLabel}</button>
            <button class="copy-button" style="right: 2.5em;">${buttonLabel}</button>
            <pre class="${showLines ? 'line-numbers' : ''}"><code class="language-${lang}"></code></pre>
        `;

    // Extrahiere den rohen Code entweder aus einem <script> oder dem inneren Text des Elements
    const scriptTag = this.querySelector('script[type="text/plain"]');
    const rawCode = scriptTag ? scriptTag.textContent : this.textContent.trim();

    // Wende das initiale Theme an
    await applyTheme(theme);

    // Setze den Code in die <code>-Box
    const codeElement = shadow.querySelector('pre > code');
    codeElement.textContent = rawCode;

    // Syntax-Hervorhebung anwenden
    Prism.highlightElement(codeElement);

    // Event-Listener für den Kopier-Button hinzufügen
    shadow.querySelector('.copy-button').addEventListener('click', () => {
      navigator.clipboard.writeText(rawCode).then(() => {
        const copyBtn = shadow.querySelector('.copy-button');
        copyBtn.textContent = '✓';
        setTimeout(() => (copyBtn.textContent = buttonLabel), 1500);
      });
    });

    // Event-Listener für den Theme-Umschalter hinzufügen
    shadow.querySelector('.theme-toggle').addEventListener('click', async () => {
      theme = this.getAttribute('theme') === 'dark' ? 'light' : 'dark';
      this.setAttribute('theme', theme);
      await applyTheme(theme); // Theme wechseln
      Prism.highlightElement(codeElement); // Syntax-Hervorhebung neu anwenden
    });
  }
}

// Registriere die benutzerdefinierte Komponente im Browser
customElements.define('porthd-codeview',PorthDCodeView);
