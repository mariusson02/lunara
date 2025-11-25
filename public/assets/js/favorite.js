
export async function handleFavoredClick(nftId){
    const apiUrl = '/favorite/toggleFavorite'
    try {
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ nft_id: nftId }),
        });
        if (!response.ok){
            throw new Error();
        }
        const data = await response.json();
        return data.favorited;
    } catch (error) {
        displayAlert(false, "Failed favoring nft, please try again");
        console.error(error);
    }
}

export async function fetchFavorites(){
    const response = await fetch('/favorite/getUserFavorites')
    if(response.ok){
        const favoritedIds = await response.json();
        return favoritedIds;
    }
}


export async function setupFavorites() {

    let isFavored = false;
    let nftFavorites = [];
    if(IS_LOGGED_IN) {
        nftFavorites = await fetchFavorites();
    }

    const favorites = document.querySelectorAll('.favorite');
    favorites.forEach((favorite) => {
        const nftId = favorite.getAttribute("data-id");
        console.log(nftId)
        console.log(nftFavorites)
        isFavored = nftFavorites.includes(parseInt(nftId));
        console.log(isFavored)
        const url = `/assets/images/favorite-heart${isFavored ? '-red': ''}.png`;
        const img = document.createElement("img");
        img.src = url;
        img.classList.add("favorite-img");
        img.alt = isFavored ? 'favored': 'not-favored';
        if(!favorite.hasChildNodes()) {
            favorite.appendChild(img);
        } else {
            return;
        }

        favorite.addEventListener("click", async () => {
            if(IS_LOGGED_IN) {
                const isFavored = await handleFavoredClick(nftId);
                if(isFavored) {
                    img.src = "assets/images/favorite-heart-red.png";
                }else{
                    img.src = "assets/images/favorite-heart.png";
                }
            } else {
                displayAlert(false,"Please log in to use this feature");
            }
        })
    })
}