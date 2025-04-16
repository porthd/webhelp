
class PorthDListSelectFilter extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: 'open' });
    let searchLength = parseInt(this.getAttribute('search-length'), 10);
    this.searchLength = (isNaN(searchLength) || searchLength < 2) ? 2 : searchLength;

    this.listTags = this.getAttribute('list-tags') || 'li,dt';
    this.defaultLevel = Math.max(1, Math.min(parseInt(this.getAttribute('default-level')) || 1, 1));
    this.suggestions = new Set();
    this.shadowRoot.innerHTML = `
            <style>
                label { ${this.getAttribute('label-style') || ''} }
                input { ${this.getAttribute('input-style') || ''} }
                .hidden { display: none; }
            </style>
            <label for="levelRange">${this.getAttribute('label-range') || 'level'}</label>
            <input id="levelRange" type="range" min="1" step="1" />
            <label for="searchInMenu">${this.getAttribute('label-search') || 'search'}</label>
            <input id="searchInMenu" value="${this.getAttribute('filter') || ''}" placeholder="${this.getAttribute('placeholder') || 'input search text'}" list="autocompleteList" autocomplete="off"/>
            <datalist id="autocompleteList"></datalist>
            <slot></slot>
        `;
    this.levelRange = this.shadowRoot.getElementById("levelRange");
    this.searchInMenu = this.shadowRoot.getElementById("searchInMenu");
    this.autocompleteList = this.shadowRoot.getElementById("autocompleteList");
    let charset = this.getAttribute('trim') || '({[]})*+-.,';
    // escape all chars for use in regexp
    charset = charset.split('').map(char => '\\' + char).join('');
    this.regexp = null;
    if ((charset) && (charset.length >0)){
      this.regexp = new RegExp(`^[${charset}]+|[${charset}]+$`, 'g');
    }

  }

  connectedCallback() {
    this.updateMaxDepth();
    this.extractSuggestions();
    this.levelRange.addEventListener("input", () => this.filterLevels());
    this.searchInMenu.addEventListener("input", () => this.filterLevels());
    this.filterLevels();
  }

  updateMaxDepth() {
    const listItems = this.querySelectorAll(this.listTags);
    let maxDepth = 0;
    listItems.forEach(li => {
      maxDepth = Math.max(maxDepth, this.getDepth(li));
    });
    let minDepth = maxDepth
    listItems.forEach(li => {
      minDepth = Math.min(minDepth, this.getDepth(li));
    });
    this.levelRange.max = maxDepth;
    this.levelRange.min = minDepth+1;
    this.levelRange.value = Math.min(this.defaultLevel, maxDepth);
  }
  trimCustomCharacters(testString) {
    // return testString.replace(new RegEx, '');
    if (this.regexp) {
      return testString.replace(this.regexp, '');
    }
    return testString;
  }

  extractSuggestions() {
    const listItems = this.querySelectorAll(this.listTags);
    listItems.forEach(li => {
      li.textContent.toLowerCase().split(/\s+/).forEach(word => {
        if (word.length > 1) {
          const newWord = this.trimCustomCharacters(word);
          this.suggestions.add(newWord);
        }
      });
    });
    this.suggestions = [...new Set(this.suggestions)];
    this.suggestions = this.suggestions.sort();
    this.updateDatalist();
  }

  updateDatalist() {
    this.autocompleteList.innerHTML = '';
    Array.from(this.suggestions).forEach(word => {
      const option = document.createElement("option");
      option.value = word;
      this.autocompleteList.appendChild(option);
    });
  }

  filterLevels() {
    const maxLevel = parseInt(this.levelRange.value, 10);
    const listItems = this.querySelectorAll(this.listTags);
    const searchText = this.searchInMenu.value.toLowerCase();

    listItems.forEach(li => {
      const depth = this.getDepth(li);
      const text = li.textContent.toLowerCase();

      if (searchText.length >= this.searchLength && text.includes(searchText)) {
        li.classList.remove("hidden");
      } else {
        const parentList = li.closest(this.listTags);
        if (parentList) {
          const parentDepth = this.getDepth(parentList);
          li.classList.toggle("hidden", parentDepth >= maxLevel);
        }
      }
    });
  }

  getDepth(element) {
    let depth = 0;
    while (element && element.parentElement && element.parentElement.closest(this.listTags)) {
      depth++;
      element = element.parentElement.closest(this.listTags);
    }
    return depth;
  }
}


export default PorthDListSelectFilter;
