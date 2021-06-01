export default class MatchingBetweenGoals {
    constructor(container) {
        this.container = container;
        this.containerBody = container.querySelector('tbody');
        this.itemPrototype = container.getAttribute('data-prototype');
        this.addBtn = container.querySelector('button.add-btn')
        this.lastIndex = this.containerBody.querySelectorAll('tr').length;

        this.onAdd = this.onAdd.bind(this);
        this.addBtn.addEventListener('click', this.onAdd);

        this.containerBody.addEventListener('click', event => {
            if (event.target.matches('button.remove-btn') || event.target.closest('button.remove-btn')) {
                this.remove(event.target.closest('tr'));
            }

            if (event.target.matches('button.move-up-btn') || event.target.closest('button.move-up-btn')) {
                this.moveUp(event.target.closest('tr'));
            }

            if (event.target.matches('button.move-down-btn') || event.target.closest('button.move-down-btn')) {
                this.moveDown(event.target.closest('tr'));
            }
        });
    }

    onAdd() {
        const content = this.itemPrototype.replaceAll(/__name__/g, this.lastIndex);

        this.lastIndex += 1;
        this.containerBody.insertAdjacentHTML('beforeend', content);
    }

    moveUp(item) {
        this.swap(item, item.previousElementSibling);
    }

    moveDown(item) {
        this.swap(item, item.nextElementSibling);
    }

    swap(itemA, itemB) {
        const itemAFromValue = itemA.querySelector('.from-input').value;
        const itemAToValue = itemA.querySelector('.to-input').value;

        const itemBFromValue = itemB.querySelector('.from-input').value;
        const itemBToValue = itemB.querySelector('.to-input').value;

        itemA.querySelector('.from-input').value = itemBFromValue;
        itemA.querySelector('.to-input').value = itemBToValue;
        itemB.querySelector('.from-input').value = itemAFromValue;
        itemB.querySelector('.to-input').value = itemAToValue;
    }

    remove(item) {
        item.parentNode.removeChild(item);
    }
}
