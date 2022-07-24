const searchInterventions = () => {
    const searchButtonsNodes = document.querySelectorAll('[data-news-search]');
    const searchButtons = Array.from(searchButtonsNodes);

    const onClickSearchByNewsCode = (event) => {
        const newsId = event.currentTarget.dataset.newsSearch;

        const searchItens = window.location.search.split('&');
        const newSearchItens = searchItens.filter(item => !item.startsWith('news_text_or_code'));
        newSearchItens.push(`news_text_or_code=${newsId}`);
        const search = newSearchItens.join('&');

        window.location.href = `${window.location.origin}${window.location.pathname}${search}`;
    };

    searchButtons.forEach((button) => button.addEventListener('click', onClickSearchByNewsCode, true));
}

export default searchInterventions;
