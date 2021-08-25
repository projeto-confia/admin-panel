const curate = () => {
    const isNewsRadio = document.querySelectorAll('[name="is_news"]');
    const isFakeNewsFieldWrapper = document.querySelector('#is_fake_news_field_wrapper');

    Array.from(isNewsRadio).forEach(isNewsRadioOption =>
        isNewsRadioOption
            .addEventListener('change', ({ target: { value: isNews } }) => {
                if (+isNews) {
                    isFakeNewsFieldWrapper.classList.remove('d-none');
                    return;
                }

                isFakeNewsFieldWrapper.classList.add('d-none');
            })
    );
};

export default curate;
