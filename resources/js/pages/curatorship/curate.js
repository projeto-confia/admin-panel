const curate = () => {
    const isNewsRadios = document.querySelectorAll('[name="is_news"]');
    const isSimilarRadios = document.querySelectorAll('[name="is_similar"]');
    const isFakeNewsFieldWrapper = document.querySelector('#is_fake_news_field_wrapper');
    const isNewsFieldWrapper = document.querySelector('#is_news_field_wrapper');

    Array.from(isNewsRadios).forEach(isNewsRadioOption =>
        isNewsRadioOption
            .addEventListener('change', ({ target: { value: isNews } }) => {
                if (+isNews) {
                    isFakeNewsFieldWrapper.classList.remove('d-none');
                    return;
                }

                isFakeNewsFieldWrapper.classList.add('d-none');
            })
    );

    Array.from(isSimilarRadios).forEach(isSimilarRadioOption =>
        isSimilarRadioOption.addEventListener('change', ({ target: { value: isSimilar } }) => {
            if (+isSimilar) {
                isNewsFieldWrapper.classList.add('d-none');
                return;
            }
            isNewsFieldWrapper.classList.remove('d-none');
        })
    );
};

export default curate;
