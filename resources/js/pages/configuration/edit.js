export const edit = () => {
    const typeValueOutlet = document.querySelector('#types-outlet');

    function addEventHandlersByType(component) {
        if (component.dataset.typename.startsWith('array')) {
            const addItemButton = component.querySelector('.add-item-btn');
            const tableBody = component.querySelector('.table-body');
            const itens = Array.from(component.querySelectorAll('.item'));

            const addRemoveButtonEventHandler = (item) => {
                const removeBtn = item.querySelector('.remove-item-btn');
                removeBtn.addEventListener('click', function() {
                    const item = removeBtn.parentElement.parentElement;
                    const hasOneItem = +item.parentElement.childElementCount === 1;
                    if (hasOneItem) {
                        return;
                    }

                    item.remove();
                }, true);
            };

            itens.forEach(addRemoveButtonEventHandler);
            addRemoveButtonEventHandler(component);

            addItemButton.addEventListener('click', () => {
                const item = component.querySelector('.item');
                const newItem = item.cloneNode(true);
                addRemoveButtonEventHandler(newItem);
                const input = newItem.querySelector('[name="value[]"]');
                input.value = '';
                tableBody.appendChild(newItem);
            }, true);
        }
    }

    const component = typeValueOutlet.children[0] ?? false;
    component && addEventHandlersByType(component);
}
