class PorthDInfoModal extends HTMLElement {
  constructor() {
    super();
    this.modal = null;
    this.errorText = this.getAttribute('error-text') || 'Modal/Button missing';
    this.errorCancel = this.getAttribute('error-canceltext') || 'Close button (data-id="cancel") is missing.';
  }

  connectedCallback() {
    this.startButton = this.querySelector('[data-id="modal-start"]');
    if (!this.startButton) return this.errorLog(this.errorText);

    const backgroundClass = this.getAttribute('background-class') || '';
    this.modal = document.createElement('div');
    this.modal.className = `hidden ${backgroundClass}`;
    this.modal.setAttribute('id', 'modal');

    const templateId = this.getAttribute('template-id');
    const internalTemplate = this.querySelector('template');
    let template = null;

    if (templateId) {
      template = document.getElementById(templateId);
    } else if (internalTemplate) {
      template = internalTemplate;
    }

    if (!template) return this.errorLog(this.errorText);
    const content = template.content.cloneNode(true);
    this.modal.appendChild(content);
    document.body.appendChild(this.modal);

    this.updateSlotContent();

    this.cancelButtons = this.modal.querySelectorAll('[data-id="cancel"]');
    if ((!this.cancelButtons) || (!this.cancelButtons.length)) {
      return this.errorLog(this.errorCancel);
    }

    this.startButton.addEventListener('click', () => this.openModal());
    this.cancelButtons.forEach(button => button.addEventListener('click', () => this.closeModal()));
    this.modal.addEventListener('click', (e) => {
      if (e.target === this.modal) this.closeModal();
    });

    document.addEventListener('keydown', (e) => {
      if (!this.modal.classList.contains('hidden') && e.key === 'Escape') {
        this.closeModal();
      }
    });

    this.observeAttributeChanges();
  }

  updateSlotContent() {
    const slots = this.modal.querySelectorAll('slot');
    slots.forEach(slot => {
      const name = slot.name;
      if (name && this.hasAttribute(`data-${name}`)) {
        slot.innerHTML = this.getAttribute(`data-${name}`);
      }
    });
  }

  observeAttributeChanges() {
    const observer = new MutationObserver(mutations => {
      for (const mutation of mutations) {
        if (mutation.type === 'attributes' && mutation.attributeName.startsWith('data-')) {
          this.updateSlotContent();
        }
      }
    });
    observer.observe(this, { attributes: true });
  }

  openModal() {
    if (!this.modal) return this.errorLog(this.errorText);
    this.modal.classList.remove('hidden');
    const dialog = this.modal.querySelector('[role="dialog"]');
    if (dialog) {
      setTimeout(() => dialog.focus(), 10);
      this.initFocusTrap(dialog);
    }
  }

  closeModal() {
    if (this.modal) {
      this.modal.classList.add('hidden');
      this.startButton?.focus();
    }
  }

  initFocusTrap(container) {
    const focusable = container.querySelectorAll('a[href], button, textarea, input, select, [tabindex]:not([tabindex="-1"])');
    const first = focusable[0];
    const last = focusable[focusable.length - 1];
    container.addEventListener('keydown', (e) => {
      if (e.key !== 'Tab') return;
      if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    });
  }

  errorLog(message) {
    this.innerHTML = '';
    if (this.getAttribute('error-hide') !== '1' || this.getAttribute('error-hide').toLowerCase() !== 'true') {
      const msgBox = document.createElement('div');
      if (this.getAttribute('error-style')) {
        msgBox.style.cssText = this.getAttribute('error-style');
      } else {
        msgBox.style.cssText = `
      color: red;
      font-weight: bold;
      margin-top: 1rem;
    `;
      }
      msgBox.innerHTML = `${message}`;
      this.appendChild(msgBox);
    }
    console.error(`[porthd-infomodal] ${message}`);
  }
}

customElements.define('porthd-infomodal', PorthDInfoModal);
