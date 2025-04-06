
class PorthDBreadcrumb extends HTMLElement {
  connectedCallback() {
    const hrefAttr = this.getAttribute('href');
    const separator = this.getAttribute('separator') ?? '<span>&nbsp;/&nbsp;</span>';
    const paramText = this.getAttribute('parameter-text');
    const showDomainRaw = (this.getAttribute('show-domain') || '').toLowerCase();
    const errorText = this.getAttribute('error-text') || 'URL missing or not valid';
    const showDomain = showDomainRaw === 'true' || showDomainRaw === '1';

    const callback = this.getAttribute('callback');

    const container = document.createElement('span');
    container.className = 'breadcrumb';

    let url;
    try {
      const base = window.location.origin + '/';
      if (!hrefAttr?.trim()) throw new Error('Missing href');
      url = new URL(hrefAttr, base);
    } catch (e) {
      const errorSpan = document.createElement('span');
      errorSpan.className = 'error';
      errorSpan.textContent = errorText;
      container.appendChild(errorSpan);
      this.appendChild(container);
      return;
    }

    const origin = url.origin !== 'null' ? url.origin : '';
    const domain = url.hostname;
    const parts = url.pathname.replace(/\/+$/, '').split('/').filter(Boolean);
    const hasParams = !!url.search;

    const addSeparator = () => {
      const sep = document.createElement('span');
      sep.innerHTML = separator;
      container.appendChild(sep);
    };

    if (showDomain && origin && domain) {
      const domainLink = document.createElement('a');
      domainLink.href = origin;
      domainLink.textContent = domain;
      container.appendChild(domainLink);
      if (parts.length > 0 || hasParams) addSeparator();
    }

    parts.forEach((part, index) => {
      const path = origin + '/' + parts.slice(0, index + 1).join('/') + '/';
      const a = document.createElement('a');
      a.href = path;
      let data = decodeURIComponent(part);
      if (callback && typeof window[callback] === 'function') {
        data = window[callback](data);
      }

      a.innerHTML = data;
      container.appendChild(a);
      if (index < parts.length - 1 || hasParams) {
        addSeparator();
      }
    });

    if (hasParams) {
      const paramLink = document.createElement('a');
      paramLink.href = url.href;
      paramLink.innerHTML = paramText?.trim() ? paramText : 'plus parameter';
      container.appendChild(paramLink);
    }

    this.appendChild(container);
  }
}

customElements.define('porthd-breadcrumb', PorthDBreadcrumb);
