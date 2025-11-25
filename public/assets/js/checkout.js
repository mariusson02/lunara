import {Starfield} from "./dist/starfield.js";


const starfield = new Starfield({
    canvasId: "checkout__bg",
    velocity: 0.1,
    acceleration: 0,
    rotationFactor: 0.0001
})

async function fetchCardNfts(idsListJsonString) {
    if(!idsListJsonString || idsListJsonString === "[]") {
        renderCardItems([]);
        return;
    }
    try {
        const idsList = JSON.parse(idsListJsonString);

        if(window.XMLHttpRequest) {
            const xmlhttp = new XMLHttpRequest();
            const url = `/checkout/getCardItems?ids=${idsList.join(',')}`;
            xmlhttp.open('GET', url,true);

            xmlhttp.onreadystatechange = function () {
                if(this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    try {
                        const nfts = JSON.parse(this.responseText);
                        renderCardItems(nfts);

                    } catch (e) {
                        console.error(e);
                    }
                }
            }
            xmlhttp.send();
        }

    } catch (e) {
        console.error(e);
    }
}

function renderCardItems(nfts) {

    const itemsContainer = document.getElementById("checkout-items");
    itemsContainer.innerText = "";

    const amountOfItems = document.getElementById("amount-of-items");
    amountOfItems.innerText = (nfts.length ?? 0) + " items";

    const totalPrice = document.getElementById("checkout-total");
    let totalPriceValue = 0;

    if(!nfts || nfts.length === 0) {
        totalPrice.innerText = "0 LUN";
        itemsContainer.innerHTML = `
            <p style="margin-top: 30px">There are no items in your cart.</p>
            <button class="secondary" onclick="redirect('/browse')">Browse Items</button>
            `
        return;

    }

    nfts.forEach((nft) => {
        // prevent owned nfts to display mistakenly
        if(nft.owner_id !== null) return;

        totalPriceValue += parseFloat(nft.price);

        const item = document.createElement("div");
        item.classList.add("checkout__item");

        const thumbnail = document.createElement("img");
        thumbnail.classList.add("checkout__item__thumbnail");
        thumbnail.src = "assets/models/" + nft.img + "/thumbnail.png";
        thumbnail.alt = nft.img + " artwork";

        const left = document.createElement("div");
        left.classList.add("checkout__item__left");

        const title = document.createElement("h3");
        title.classList.add("checkout__item__title")
        title.innerText = nft.name;

        const subtitle = document.createElement("p");
        subtitle.classList.add("checkout__item__subtitle");
        subtitle.innerText = nft.subtitle;

        const right = document.createElement("div");
        right.classList.add("checkout__item__right");

        const price = document.createElement("div");
        price.classList.add("checkout__item__price");

        const value = document.createElement("span");
        value.classList.add("checkout__item__price__value");
        value.innerText = nft.price + " LUN";

        const coin = document.createElement("div");
        coin.classList.add("nft__price-coin");

        const removeButton = document.createElement("button");
        removeButton.innerHTML = "&#10005;";
        removeButton.classList.add("checkout__item__remove-btn");
        removeButton.addEventListener("click", () => {
            const currentCartItemsCookie = getCookie(cartCookie);
            try {
                const currentCartItems = JSON.parse(currentCartItemsCookie);
                const nftId = nft.id.toString();
                if(currentCartItems.includes(nftId)) {
                    const newCardItems = currentCartItems.filter((cardItem) => cardItem !== nftId);
                    setCookie(cartCookie, JSON.stringify(newCardItems), 7);
                    item.remove();
                }
            } catch (e) {
                console.error(e);
            }
        })

        itemsContainer.appendChild(item);
        item.appendChild(thumbnail);
        item.appendChild(left);
        item.appendChild(right);
        left.appendChild(title);
        left.appendChild(subtitle);
        right.appendChild(removeButton);
        right.appendChild(price);
        price.appendChild(value);
        price.appendChild(coin);
    })

    totalPrice.innerText = totalPriceValue.toFixed(2) + " LUN";
}

async function handleCheckout() {
    try {
        if(!IS_LOGGED_IN) {
            displayAlert(false, "You must be logged in to purchase");
            return;
        }
        const url = "/checkout/checkout";
        const response = await fetch(url);
        if(!response.ok) {
            displayAlert(false, "Something went wrong, please try again");
            return;
        }
        const result = await response.json();
        const success = result.success;
        if(success) {
            setCookie(cartCookie, "", 7);
            redirect("account/myNfts");
        } else {
            displayAlert(false, "Something went wrong, please try again");
        }
    } catch (e) {
        displayAlert(false, "Something went wrong, please try again");
    }
}

function setupCheckout() {
    const checkoutButton = document.getElementById("checkout-purchase");
    checkoutButton && checkoutButton.addEventListener("click", () => {
        handleCheckout();
    })
}

function setupClearBtn() {
    const clearBtn = document.getElementById("checkout-clear");
    clearBtn && clearBtn.addEventListener("click", () => {
        setCookie(cartCookie, "", 7);
        fetchCardNfts("[]");
    })
}

setupClearBtn();
setupCheckout();


const nftIds = getCookie(cartCookie);
fetchCardNfts(nftIds);


