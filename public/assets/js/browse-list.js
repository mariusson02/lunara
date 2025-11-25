import { handleFavoredClick, fetchFavorites } from "./favorite.js";

const apiUrl = '/browse/getNfts';
const limit = 6;
let offset = 0;
let isFetching = false;

const loadMoreButton = document.getElementById('load-more');

const toggleButton = document.querySelector(".browse__filter__toggle");
const filterContent = document.querySelector(".browse__filter__content");
toggleButton.addEventListener("click", () => {
    toggleButton.classList.toggle("active");
    filterContent.classList.toggle("expanded");
});

/**
 * Validates the input filters for the browse section.
 *
 * This function checks that the minimum price is less than the maximum price,
 * and that the values entered are valid.
 * It also manages the error messages associated with invalid input.
 *
 * @param {Object} filters The filters to be validated.
 * @returns {boolean} True if all filters are valid, false otherwise.
 */
function validateInput(filters) {

    const minPriceErrorId = 'browse__filter__error__min-price';
    const maxPriceErrorId = 'browse__filter__error__max-price';
    const rangePriceErrorId = 'browse__filter__error__price-range';

    const minPriceError = document.getElementById(minPriceErrorId);
    const maxPriceError = document.getElementById(maxPriceErrorId);
    const rangePriceError = document.getElementById(rangePriceErrorId);

    if (Object.keys(filters).length === 0) {
        if(minPriceError) minPriceError.remove();
        if(maxPriceError) maxPriceError.remove();
        if(rangePriceError) rangePriceError.remove();
        return true;
    }

    const errorContainer = document.getElementById('browse__filter__error__container');

    if (filters.min_price < 0 && !minPriceError) {
        const error = document.createElement('div');
        error.className = 'browse__filter__error';
        error.id = minPriceErrorId;
        error.innerHTML = 'Please enter a valid min price!';
        errorContainer.appendChild(error);
    } else if (minPriceError) {
        minPriceError.remove();
    }

    if (filters.max_price < 0 && !maxPriceError) {
        const error = document.createElement('div');
        error.className = 'browse__filter__error';
        error.id = maxPriceErrorId;
        error.innerHTML = 'Please enter a valid max price!';
        errorContainer.appendChild(error);
    } else if (maxPriceError) {
        maxPriceError.remove();
    }

    if (filters.max_price < filters.min_price && !rangePriceError) {
        const error = document.createElement('div');
        error.className = 'browse__filter__error';
        error.id = rangePriceErrorId;
        error.innerHTML = 'The min price must be smaller than the max price!';
        errorContainer.appendChild(error);
    } else if (rangePriceError) {
        rangePriceError.remove();
    }

    return errorContainer.children.length === 0;
}

async function fetchData(filters = {}) {

    if(isFetching || !validateInput(filters)) return;

    try {
        isFetching = true;
        const params = new URLSearchParams(({limit, offset, ...filters}));

        const response = await fetch(`${apiUrl}?${params.toString()}`);
        if(!response.ok) {
            throw new Error('Failed to fetch data');
        }

        const data = await response.json();
        if (offset === 0) {
            document.getElementById('items-container').innerHTML = '';
        }
        renderItems(data);

        offset += data.length;

        toggleLoadMoreButton(data.length);
    } catch (error) {
        console.error(error);
    } finally {
        isFetching = false;
    }
}

/**
 * Renders the NFT items to the page.
 *
 * This function creates the HTML elements to display the NFTs, including the
 * thumbnail, title, price, and favorite button. It also handles marking an
 * NFT as "sold" if it has an owner.
 *
 * @param {Array} items The NFT items to render.
 */
async function renderItems(items) {
    const container = document.getElementById('items-container');
    if(items.length === 0 && offset === 0) {
        container.innerHTML = '<p>No items found.</p>';
        return;
    }

    let nftFavorites = [];

    if(IS_LOGGED_IN) {
        nftFavorites = await fetchFavorites();
    }

    items.forEach((item) => {
        const card = document.createElement('div');
        card.className = 'browse__card';

        const wrapper = document.createElement('div');
        wrapper.classList.add('browse__card__wrapper', 'reveal');
        wrapper.addEventListener("click", () => {
            redirect(`nft?id=${item.id}`);
        })

        const thumbnail = document.createElement("img");
        thumbnail.src = "assets/models/" + item.img + "/thumbnail.png";
        thumbnail.className = "browse__card__img";
        thumbnail.alt = item.img + " artwork";

        const content = document.createElement('div');
        content.className = 'browse__card__content';

        const titleAndFavoriteWrapper= document.createElement('div');
        titleAndFavoriteWrapper.className = 'browse__card__title__wrapper';

        const favoriteHeart  = document.createElement("img");
        favoriteHeart.classList.add("browse__card__favorite");

        if (nftFavorites && nftFavorites.length > 0 && nftFavorites.includes(item.id)){
            favoriteHeart.classList.add("favorited");
            favoriteHeart.src = "assets/images/favorite-heart-red.png";
        }
        else {
            favoriteHeart.classList.remove("favorited")
            favoriteHeart.src = "assets/images/favorite-heart.png";
        }

        favoriteHeart.addEventListener("click", async (event) => {
            event.stopPropagation();
            if(IS_LOGGED_IN) {
                const isFavorited = await handleFavoredClick(item.id);
                if(isFavorited) {
                    favoriteHeart.src = "assets/images/favorite-heart-red.png";
                }else{
                    favoriteHeart.src = "assets/images/favorite-heart.png";
                }
                favoriteHeart.classList.toggle("favorited",isFavorited);
            } else {
                displayAlert(false,"Please log in to use this feature");
            }
        })
        let soldLabel = null;
        if(item.owner_id !== null) {
            soldLabel = document.createElement("span");
            soldLabel.innerText = "[ SOLD ]";
            soldLabel.classList.add("sold-label");
        }

        const title = document.createElement('h2');
        title.innerHTML = item.name;

        const box = document.createElement("div");
        box.className = "browse__card__content__info";

        const type = document.createElement("span");
        type.innerHTML = item.type;

        const price = document.createElement('div');
        price.className = "browse__card__content__price";

        const coin = document.createElement("div");
        coin.className = "nft__price-coin";

        wrapper.addEventListener("mouseenter", () => {
            coin.classList.add("inverted");
        })
        wrapper.addEventListener("mouseleave", () => {
            coin.classList.remove("inverted");
        })

        const value = document.createElement('div');
        value.innerHTML = item.price + " LUN";

        container.appendChild(card);
        card.appendChild(wrapper);
        wrapper.appendChild(thumbnail);
        wrapper.appendChild(content);
        content.appendChild(titleAndFavoriteWrapper);
        soldLabel && titleAndFavoriteWrapper.appendChild(soldLabel);
        titleAndFavoriteWrapper.appendChild(favoriteHeart);
        titleAndFavoriteWrapper.appendChild(title);
        box.appendChild(type);
        box.appendChild(price);
        price.appendChild(value);
        price.appendChild(coin);
        content.appendChild(box);
    })

    observeRevealElements();
}


function getFilters() {
    const filters = {};

    const search = document.getElementById('browse-search');
    if(search && search.value) filters.search = search.value;

    const type = document.getElementById('browse-type');
    if(type && type.value) filters.type = type.value;

    const minPrice = document.getElementById('browse-min-price');
    if(minPrice && minPrice.value) filters.min_price = minPrice.value;

    const maxPrice = document.getElementById('browse-max-price');
    if(maxPrice && maxPrice.value) filters.max_price = maxPrice.value;

    const available = document.getElementById('browse-available');
    if(available && available.checked) filters.available = available.checked;

    return filters;
}


// Load more Button

function toggleLoadMoreButton(count) {
    loadMoreButton.style.display = count < limit ? 'none' : 'block';
}

loadMoreButton.addEventListener('click', () => {
    fetchData(getFilters());
});

function setupInputListeners() {
    const inputs = [
        'browse-search',
        'browse-type',
        'browse-available',
        'browse-min-price',
        'browse-max-price'
    ];

    inputs.forEach((id) => {
        const element = document.getElementById(id) ?? null;
        if(!element) return;
        element.addEventListener('input', () => {
            offset = 0;
            fetchData(getFilters());
        })
    });
}
setupInputListeners();
fetchData(getFilters());