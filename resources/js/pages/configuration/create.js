export const create = () => {
    const typeValueOutlet = document.querySelector('#types-outlet');
    const typesTemplatesWrapper = document.querySelector('#types-templates');
    const typeSelect = document.querySelector('#type');

    function createComponent(typeName) {
        const typeTemplate = typesTemplatesWrapper.querySelector(`[data-typename="${typeName}"]`);
        return typeTemplate.cloneNode(true);
    }

    function addRadiosValidatorMinMaxHandler(component) {
        const minMaxRadios = component.querySelectorAll('[name="uses_min_max_validators"]');
        const wrapperMinMax = component.querySelector('#wrapper-min-max-value');

        Array
            .from(minMaxRadios)
            .forEach(option =>
                option.addEventListener('change', ({ target: { value } }) =>
                    +value
                        ? wrapperMinMax.classList.remove('d-none')
                        : wrapperMinMax.classList.add('d-none')
                )
            );
    }

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

        if (component.dataset.typename === 'int') {
            addRadiosValidatorMinMaxHandler(component);
        }
    }

    function clearOutlet() {
        typeValueOutlet.innerHTML = '';
    }

    function appendComponent(component) {
        typeValueOutlet.appendChild(component);
    }

    typeSelect.addEventListener('change', (event) => {
        const typeName = event.target.value;

        if (!typeName) {
            return clearOutlet();
        }

        const component = createComponent(typeName);
        clearOutlet();
        addEventHandlersByType(component);
        appendComponent(component);
    });

    // On redirect back from validation, binds events handlers for elements already rendered
    const component = typeValueOutlet.children[0] ?? false;
    if (component && /(int|float)/.test(component.dataset.typename)) {
        addRadiosValidatorMinMaxHandler(component);
    }
}
