class PorthDTocGenerator extends HTMLElement {
  static observedAttributes = ['rebuild'];

  constructor() {
    super();
    this.idPrefix = this.getAttribute('pretext') || 'toc_';
    this.randomIdPart = Math.random().toString(36).substring(2, 10);
    this.counter = [0, 0, 0, 0, 0, 0];
  }

  connectedCallback() {
    this.buildTOC();
  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (name === 'rebuild') {
      this.buildTOC();
    }
  }

  buildTOC() {
    this.innerHTML = '';
    const blockSelector = this.getAttribute('block') || 'body';
    const block = document.querySelector(blockSelector);

    if (!block) {
      this.showError();
      return;
    }

    const headings = block.querySelectorAll('h1, h2, h3, h4, h5, h6');
    if (!headings.length) {
      this.showError();
      return;
    }

    const addNumber = this.getAttribute('add-number') === 'true';
    const start = this.getAttribute('chapter-start');
    if (addNumber && start && /^\d+\.\d+\.\d+\.\d+\.\d+\.\d+$/.test(start)) {
      this.counter = start.split('.').map(Number);
    } else {
      this.counter = [0, 0, 0, 0, 0, 0];
    }

    const tocList = document.createElement('ul');
    tocList.className = 'toc';

    let currentLists = Array(6).fill(null);
    currentLists[0] = tocList;

    let lastListItems = Array(6).fill(null);

    headings.forEach((heading, index) => {
      const level = parseInt(heading.tagName[1]) - 1;
      const anchorId = `${this.idPrefix}${this.randomIdPart}_${index}`;

      const anchorSpan = document.createElement('span');
      anchorSpan.id = anchorId;
      anchorSpan.className = 'anchor';
      heading.insertBefore(anchorSpan, heading.firstChild);

      if (addNumber) {
        this.counter[level]++;
        for (let i = level + 1; i < 6; i++) {
          this.counter[i] = 0;
        }
      }

      const listItem = document.createElement('li');
      const link = document.createElement('a');
      link.href = `#${anchorId}`;
      const numbering = addNumber ? this.counter.slice(0, level + 1).join('.') + ' ' : '';
      link.textContent = numbering + heading.textContent;
      listItem.appendChild(link);

      // Fallback auf gültige höhere Liste oder top-level
      let parentList = null;
      for (let i = level - 1; i >= 0; i--) {
        if (currentLists[i]) {
          parentList = currentLists[i];
          break;
        }
      }
      if (!parentList) parentList = tocList;

      parentList.appendChild(listItem);

      // Neue Liste für tiefere Ebene
      const subList = document.createElement('ul');
      subList.className = 'toc';
      listItem.appendChild(subList);
      currentLists[level] = subList;
      lastListItems[level] = listItem;

      for (let i = level + 1; i < 6; i++) {
        currentLists[i] = null;
        lastListItems[i] = null;
      }
    });

    this.appendChild(tocList);
  }

  showError() {
    const errorText = this.getAttribute('error-text') ||
      'Directory can not be created. Missing block or missing headline-tag.';
    const errorStyle = this.getAttribute('error-style') || 'color: red; font-weight: bold;';

    const error = document.createElement('div');
    error.className = 'error';
    error.setAttribute('style', errorStyle);
    error.innerHTML = errorText;
    this.appendChild(error);
  }
}

customElements.define('porthd-tocgenerator', PorthDTocGenerator);

