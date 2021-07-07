export default class RefineGoals {
  constructor(container) {
    this.container = container;
    this.containerBody = container.querySelector('tbody');
    this.itemPrototype = container.getAttribute('data-prototype');
    this.addBtn = container.querySelector('button.add-btn');
    this.lastIndex = this.containerBody.querySelectorAll('tr').length;

    this.onAdd = this.onAdd.bind(this);
    this.addBtn.addEventListener('click', this.onAdd);

    this.containerBody.addEventListener('click', (event) => {
      if (
        event.target.matches('button.remove-btn') ||
        event.target.closest('button.remove-btn')
      ) {
        this.remove(event.target.closest('tr'));
      }
    });
  }

  onAdd() {
    const content = this.itemPrototype.replaceAll(/__name__/g, this.lastIndex);

    this.lastIndex += 1;
    this.containerBody.insertAdjacentHTML('beforeend', content);
  }

  static remove(item) {
    item.parentNode.removeChild(item);
  }
}
