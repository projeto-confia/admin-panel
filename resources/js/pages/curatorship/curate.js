const curate = () => {
    const isNewsRadios = document.querySelectorAll('[name="is_news"]');
    const isSimilarRadios = document.querySelectorAll('[name="is_similar"]');
    const isFakeRadios = document.querySelectorAll('[name="is_fake_news"]');
    const isNewsFieldWrapper = document.querySelector('#is_news_field_wrapper');
    const isFakeNewsFieldWrapper = document.querySelector('#is_fake_news_field_wrapper');

    const resetRadiosInputs = inputs => Array.from(inputs).forEach(input => input.checked = false);

    Array.from(isNewsRadios).forEach(isNewsRadioOption =>
        isNewsRadioOption
            .addEventListener('change', ({ target: { value: isNews } }) => {
                resetRadiosInputs(isFakeRadios);
                if (+isNews) {
                    isFakeNewsFieldWrapper.classList.remove('d-none');
                    return;
                }

                isFakeNewsFieldWrapper.classList.add('d-none');
            })
    );

    Array.from(isSimilarRadios).forEach(isSimilarRadioOption =>
        isSimilarRadioOption.addEventListener('change', ({ target: { value: isSimilar } }) => {
            resetRadiosInputs(isNewsRadios);
            resetRadiosInputs(isFakeRadios);
            isFakeNewsFieldWrapper.classList.add('d-none');

            if (+isSimilar) {
                isNewsFieldWrapper.classList.add('d-none');
                return;
            }
            resetRadiosInputs(isNewsRadios);
            resetRadiosInputs(isFakeRadios);
            isNewsFieldWrapper.classList.remove('d-none');
        })
    );
};

export default curate;
