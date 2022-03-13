export const create = () => {
    const typeValueOutlet = document.querySelector('#types-outlet');
    const typesTemplatesWrapper = document.querySelector('#types-templates');
    const typeSelect = document.querySelector('#type');

    function createComponent(typeName) {
        const typeTemplate = typesTemplatesWrapper.querySelector(`[data-typename="${typeName}"]`);
        return typeTemplate.cloneNode(true);
    }

    function clearOutlet() {
        typeValueOutlet.innerHTML = '';
    }

    function appendComponent(component) {
        typeValueOutlet.appendChild(component);
    }

    function createDefaultValueComponent(component) {
        const defaultValueComponent = component.cloneNode(true);
        const valueElement = defaultValueComponent.querySelector('#value');
        const label = defaultValueComponent.querySelector('[for="value"]');

        defaultValueComponent.classList.add('mt-2');
        valueElement.id = "defaultValue";
        valueElement.name = "defaultValue";
        valueElement.setAttribute('placeholder', 'Valor padrão');
        label.setAttribute('for', valueElement.id);
        label.innerHTML = 'Valor padrão';

        return defaultValueComponent;
    }

    typeSelect.addEventListener('change', (event) => {
        const typeName = event.target.value;

        if (!typeName) {
            return clearOutlet();
        }

        const component = createComponent(typeName);
        const defaultValueComponent = createDefaultValueComponent(component);
        clearOutlet();
        appendComponent(component);
        appendComponent(defaultValueComponent);
    });
}
