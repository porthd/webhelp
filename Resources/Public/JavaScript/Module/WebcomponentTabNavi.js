class PorthDTabNavi extends HTMLElement {

  selfname = 'porthd-tabnavi';

  constructor() {
    super();
  }


  connectedCallback() {
    this._injectStylesIfNeeded();


    const startpanel = this.getAttribute('startpanel');
    if (!startpanel) {
      console.error("Fehler: Attribut 'startpanel' fehlt bei <" + this.selfname + ">.");
      return;
    }

    const children = Array.from(this.children);
    const startNodes = children.filter(el => el.matches(startpanel));

    if (startNodes.length === 0) {
      console.error("Fehler: Keine passenden Elemente für 'startpanel' gefunden.");
      return;
    }

    const name = this.getAttribute('name') || this._generateRandomName();
    const tabList = document.createElement('nav');
    tabList.className = 'tablist';
    tabList.setAttribute('role', 'tablist');

    if (this.hasAttribute('listclass')) {
      tabList.classList.add(this.getAttribute('listclass'));
    }
    if (this.hasAttribute('liststyle')) {
      tabList.setAttribute('style', this.getAttribute('liststyle'));
    }

    const panelWrappers = [];
    let index = 0;
    const startIndexList = [];

    children.forEach((child, idx) => {
      if (child.matches(startpanel)) {
        startIndexList.push(idx);
      }
    });

    const panels = [];

    if (startIndexList[0] > 0) {
      console.warn("Warnung: Elemente vor dem ersten startpanel-Element erkannt. Sie werden in einem 'default'-Tab gruppiert.");
      panels.push({
        name: 'default',
        elements: children.slice(0, startIndexList[0])
      });
    }

    for (let i = 0; i < startIndexList.length; i++) {
      const startIdx = startIndexList[i];
      const endIdx = startIndexList[i + 1] || children.length;
      panels.push({
        name: this._getTabName(children[startIdx], index),
        elements: children.slice(startIdx, endIdx)
      });
      index++;
    }

    let foundStartTab = false;

    panels.forEach((panel, i) => {
      const id = `${name}-${i}`;
      const tabBtn = document.createElement('button');
      tabBtn.setAttribute('role', 'tab');
      tabBtn.textContent = panel.name;
      tabBtn.dataset.tab = id;

      if (this.hasAttribute('tabclass')) {
        tabBtn.classList.add(this.getAttribute('tabclass'));
      }
      if (this.hasAttribute('tabstyle')) {
        tabBtn.setAttribute('style', this.getAttribute('tabstyle'));
      }

      tabBtn.addEventListener('click', () => this._showTab(id));
      tabList.appendChild(tabBtn);

      const panelDiv = document.createElement('div');
      panelDiv.classList.add('tabpanel');
      panelDiv.id = id;
      panelDiv.setAttribute('role', 'tabpanel');

      if (this.hasAttribute('panelclass')) {
        panelDiv.classList.add(this.getAttribute('panelclass'));
      }
      if (this.hasAttribute('panelstyle')) {
        panelDiv.setAttribute('style', this.getAttribute('panelstyle'));
      }

      panel.elements.forEach(el => panelDiv.appendChild(el));
      panelWrappers.push(panelDiv);

      const startAttr = panel.elements[0]?.getAttribute('starttab');
      if (!foundStartTab && (startAttr === '' || startAttr === '1')) {
        panelDiv.classList.add('active');
        tabBtn.classList.add('active');
        foundStartTab = true;
      }
    });

    // Fallback: Wenn kein starttab gesetzt ist, aktiviere den ersten Tab
    if (!foundStartTab && panelWrappers.length > 0 && tabList.children.length > 0) {
      panelWrappers[0].classList.add('active');
      tabList.children[0].classList.add('active');
    }

    this.innerHTML = '';
    if (panels.length > 1) {
      this.appendChild(tabList);
    }
    panelWrappers.forEach(p => this.appendChild(p));
  }

  _injectStylesIfNeeded() {
    const stylePart = this.selfname;
    const styleId = `${stylePart}-styles`;

    // Überprüfen, ob die Styles bereits definiert wurden
    if (!document.getElementById(styleId)) {
      const style = document.createElement('style');
      style.id = styleId;
      style.textContent = `
        ${stylePart} nav.tablist {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        ${stylePart} nav.tablist button {
            cursor: pointer;
            padding: 0.5rem 1rem;
            background: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        ${stylePart} nav.tablist button.active {
            background-color: #ddd;
            font-weight: bold;
        }
        ${stylePart} .tabpanel {
            display: none;
        }
        ${stylePart} .tabpanel.active {
            display: block;
        }
      `;
      document.head.appendChild(style);
    }
  }

  _showTab(id) {
    this.querySelectorAll('.tabpanel').forEach(p => p.classList.remove('active'));
    this.querySelectorAll('nav.tablist button').forEach(b => b.classList.remove('active'));
    this.querySelector(`#${id}`)?.classList.add('active');
    this.querySelector(`nav.tablist button[data-tab="${id}"]`)?.classList.add('active');
  }

  _generateRandomName() {
    const letters = 'abcdefghijklmnopqrstuvwxyz';
    const numbers = '0123456789';
    let name = letters[Math.floor(Math.random() * letters.length)];
    for (let i = 0; i < 28; i++) {
      name += (Math.random() > 0.2777) ? letters[Math.floor(Math.random() * letters.length)] : numbers[Math.floor(Math.random() * numbers.length)];
    }
    name += letters[Math.floor(Math.random() * letters.length)];
    return name;
  }

  _getTabName(el, index) {
    const attrName = el.getAttribute('tabname');
    if (attrName) return attrName;
    const firstWord = el.textContent.trim().split(/\s+/)[0];
    return firstWord || `tab${index}`;
  }
}

export default PorthDTabNavi
