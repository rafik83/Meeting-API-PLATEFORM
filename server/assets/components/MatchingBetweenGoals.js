export default class MatchingBetweenGoals {
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
        MatchingBetweenGoals.remove(event.target.closest('tr'));
      }

      if (
        event.target.matches('button.move-up-btn') ||
        event.target.closest('button.move-up-btn')
      ) {
        MatchingBetweenGoals.moveUp(event.target.closest('tr'));
      }

      if (
        event.target.matches('button.move-down-btn') ||
        event.target.closest('button.move-down-btn')
      ) {
        MatchingBetweenGoals.moveDown(event.target.closest('tr'));
      }
    });
  }

  onAdd() {
    const content = this.itemPrototype.replaceAll(/__name__/g, this.lastIndex);

    this.lastIndex += 1;
    this.containerBody.insertAdjacentHTML('beforeend', content);
  }

  static moveUp(item) {
    MatchingBetweenGoals.swap(item, item.previousElementSibling);
  }

  static moveDown(item) {
    MatchingBetweenGoals.swap(item, item.nextElementSibling);
  }

  static swap(itemA, itemB) {
    if (!itemB) {
      return;
    }

    const itemAFromValue = itemA.querySelector('.from-input').value;
    const itemAToValue = itemA.querySelector('.to-input').value;

    const itemBFromValue = itemB.querySelector('.from-input').value;
    const itemBToValue = itemB.querySelector('.to-input').value;

    const itemABis = itemA;
    const itemBBis = itemB;

    itemABis.querySelector('.from-input').value = itemBFromValue;
    itemABis.querySelector('.to-input').value = itemBToValue;
    itemBBis.querySelector('.from-input').value = itemAFromValue;
    itemBBis.querySelector('.to-input').value = itemAToValue;
  }

  static remove(item) {
    item.parentNode.removeChild(item);
  }
}
