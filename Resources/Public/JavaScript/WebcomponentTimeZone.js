class PorthDTimezone extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: 'open' });
  }

  connectedCallback() {
    this.render();
  }

  static get observedAttributes() {
    return ['datetime', 'to-timezone', 'source-timezone', 'aria-text', 'error-text', 'parse-format', 'month-names'];
  }

  attributeChangedCallback() {
    this.render();
  }

  parseInput(datetimeRaw, format, monthNamesAttr) {
    const now = new Date();
    const monthNames = (monthNamesAttr || '').split(',').map(m => m.trim().toLowerCase());

    if (format === 'H:i') {
      return new Date(`${now.toISOString().split('T')[0]}T${datetimeRaw}`);
    } else if (format === 'Y-m-d') {
      return new Date(`${datetimeRaw}T00:00:00`);
    } else if (format === 'Y-m-d H:i') {
      return new Date(datetimeRaw.replace(' ', 'T'));
    } else if (format === 'H:i:s') {
      return new Date(`${now.toISOString().split('T')[0]}T${datetimeRaw}`);
    } else if (format === 'd.m.Y') {
      const [d, m, y] = datetimeRaw.split('.');
      return new Date(`${y}-${m}-${d}T00:00:00`);
    } else if (format === 'm/d/Y') {
      const [m, d, y] = datetimeRaw.split('/');
      return new Date(`${y}-${m}-${d}T00:00:00`);
    } else if (format === 'Y-m-d H:i:s') {
      return new Date(datetimeRaw.replace(' ', 'T'));
    } else if (monthNames.length > 0 && /\d{1,2}\s+[^\s]+\s+\d{4}/.test(datetimeRaw)) {
      const [day, monthStrRaw, yearStr] = datetimeRaw.split(/\s+/);
      const monthStr = monthStrRaw.trim().toLowerCase();
      const monthIndex = monthNames.findIndex(m => m === monthStr);
      const month = monthIndex !== -1 ? (monthIndex % 12) : 0;
      const year = parseInt(yearStr);
      return new Date(year, month, parseInt(day));
    } else {
      return new Date(datetimeRaw);
    }
  }
  render() {
    const datetimeAttr = this.getAttribute('datetime');
    const toTimezone = this.getAttribute('to-timezone') || 'UTC';
    const sourceTimezone = this.getAttribute('source-timezone') || 'UTC';
    const parseFormat = this.getAttribute('parse-format') || '';
    const monthNamesAttr = this.getAttribute('month-names') || '';
    const ariaText = this.getAttribute('aria-text') || 'Konvertierte Zeit in';
    const errorText = this.getAttribute('error-text') || 'Ungültige Zeitzone';
    const datetimeRaw = datetimeAttr || this.textContent.trim() || new Date().toISOString();

    try {
      const parsedDate = this.parseInput(datetimeRaw, parseFormat, monthNamesAttr);

      const formatter = new Intl.DateTimeFormat('en-US', {
        timeZone: sourceTimezone,
        year: 'numeric', month: '2-digit', day: '2-digit',
        hour: '2-digit', minute: '2-digit', second: '2-digit',
        hour12: false
      });

      const dateParts = formatter.formatToParts(parsedDate).reduce((acc, part) => {
        acc[part.type] = part.value;
        return acc;
      }, {});

      const { year, month, day, hour, minute, second } = dateParts;

      const dateInUTC = new Date(Date.UTC(
        parseInt(year),
        parseInt(month) - 1,
        parseInt(day),
        parseInt(hour),
        parseInt(minute),
        parseInt(second)
      ));

      const output = new Intl.DateTimeFormat('de-DE', {
        timeZone: toTimezone,
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      }).format(dateInUTC);

      this.shadowRoot.innerHTML = `<span aria-label="${ariaText}">${output} (${toTimezone})</span>`;
    } catch (error) {
      this.shadowRoot.innerHTML = `<span aria-label="${errorText}">${errorText}</span>`;
    }
  }
}

customElements.define('porthd-timezone', PorthDTimezone);

