export const userCreate = () => {
    console.log('Called');
    const isAdminCheckbox = document.querySelector('#is_admin');
    const alertBox = document.querySelector('#is_admin_alert');

    isAdminCheckbox.addEventListener('change', (event) => {
        const { target: { checked } } = event;

        alertBox.setAttribute('aria-disabled', !checked);

        if (checked) {
            alertBox.classList.remove('d-none');
            return;
        }

        alertBox.classList.add('d-none');
    });
}
