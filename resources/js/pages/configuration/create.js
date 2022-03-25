export const create = () => {
    const typeValueOutlet = document.querySelector('#types-outlet');
    const typesTemplatesWrapper = document.querySelector('#types-templates');
    const typeSelect = document.querySelector('#type');

    function createComponent(typeName) {
        const typeTemplate = typesTemplatesWrapper.querySelector(`[data-typename="${typeName}"]`);
        return typeTemplate.cloneNode(true);
    }

    function addEventHandlersByType(component) {
        if (component.dataset.typename === 'array[string]') {
            const addItemButton = component.querySelector('.add-item-btn');
            const tableBody = component.querySelector('.table-body');

            const getRemoveItemButton = (item) => item.querySelector('.remove-item-btn');

            const addRemoveButtonEventHandler = (item) => {
                const removeBtn = getRemoveItemButton(item);
                removeBtn.addEventListener('click', function() {
                    const item = removeBtn.parentElement.parentElement;
                    const hasOneItem = +item.parentElement.childElementCount === 1;
                    if (hasOneItem) {
                        return;
                    }

                    item.remove();
                }, true);
            };

            addRemoveButtonEventHandler(component);

            addItemButton.addEventListener('click', (e) => {
                const item = component.querySelector('.item');
                const newItem = item.cloneNode(true);
                addRemoveButtonEventHandler(newItem);
                newItem.value = "";

                tableBody.appendChild(newItem);
            }, true);
        }
    }



    function clearOutlet() {
        typeValueOutlet.innerHTML = '';
    }

    function appendComponent(component) {
        typeValueOutlet.appendChild(component);
    }

    function boolDefaultValueComponentFactory(component) {
        const defaultValueComponent = component.cloneNode(true);
        const inputTrue = defaultValueComponent.querySelector('#value_true');
        const inputFalse = defaultValueComponent.querySelector('#value_false');
        const labelTrue = defaultValueComponent.querySelector('[for="value_true"]');
        const labelFalse = defaultValueComponent.querySelector('[for="value_false"]');
        const wrapperLabel = defaultValueComponent.querySelector(`#${inputTrue.name}_label`);

        const addsDefaultSuffixForInput = (input) => {
            input.id = `${input.id}_default`;
            input.name = "default_value";
        };

        const updatesLabelFor = (label, input) => {
            label.setAttribute('for', input.id);
        };

        defaultValueComponent.classList.add('mt-3');

        addsDefaultSuffixForInput(inputTrue);
        addsDefaultSuffixForInput(inputFalse);

        updatesLabelFor(labelTrue, inputTrue);
        updatesLabelFor(labelFalse, inputFalse);

        wrapperLabel.innerHTML = 'Valor padrão';

        return defaultValueComponent;
    }

    function defaultValueComponentFactory(component) {
        const defaultValueComponent = component.cloneNode(true);
        const valueElement = defaultValueComponent.querySelector('#value');
        const label = defaultValueComponent.querySelector('[for="value"]');

        defaultValueComponent.classList.add('mt-2');
        valueElement.id = "default_value";
        valueElement.name = "default_value";
        valueElement.setAttribute('placeholder', 'Valor padrão');
        label.setAttribute('for', valueElement.id);
        label.innerHTML = 'Valor padrão';

        return defaultValueComponent;
    }

    function getDefaultValueComponentFactory(type) {
        const map = {
            'bool': boolDefaultValueComponentFactory,
        };

        return map[type] ?? defaultValueComponentFactory;
    }

    typeSelect.addEventListener('change', (event) => {
        const typeName = event.target.value;

        if (!typeName) {
            return clearOutlet();
        }

        const component = createComponent(typeName);
       // const defaultValueComponent = getDefaultValueComponentFactory(component.dataset.typename)(component);
        clearOutlet();
        addEventHandlersByType(component);
        appendComponent(component);
        //appendComponent(defaultValueComponent);
    });
}
