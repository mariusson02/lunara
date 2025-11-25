import { ModelViewer } from "./dist/modelviewer.js";
import { setupFavorites } from "./favorite.js";

const viewer = new ModelViewer("model-display");
const modelPath = document.getElementById("model-display").dataset.path;
viewer.loadModel(`assets/models/${modelPath}/`);

const buyButton = document.getElementById("buy");

const nftId = buyButton.getAttribute("data-id");

const isavailable = Boolean(Number(document.getElementById("is-available").getAttribute("data-is-available")));

function isNftInCartAlready(nftId) {
    let cart = getCookie(cartCookie);
    let cartItems;
    try {
        cartItems = cart ? JSON.parse(cart) : [];
    } catch (e) {
        console.error("Failed to parse cart items to check if nft with id " + nftId + " is a included");
        return false;
    }
    return cartItems.includes(nftId);
}

function addToCart(nftId) {
    let cart = getCookie(cartCookie);
    let cartItems = cart ? JSON.parse(cart) : [];

    if(!cartItems.includes(nftId)) {
        cartItems.push(nftId);
        setCookie(cartCookie, JSON.stringify(cartItems), 7);

    }
}

if(isNftInCartAlready(nftId)) {
    buyButton.innerText = "go to cart";
    buyButton.addEventListener("click", () => {
        redirect("/checkout");
    })
} else {

    let clicked = false;

    buyButton.addEventListener("click", () => {
        if (isavailable || clicked) return;
        clicked = true;

        addToCart(nftId)

        const successText = document.createElement("span");
        successText.innerText = "Successfully added to cart!";
        successText.style.textAlign = "center";
        successText.style.marginTop = ".5rem";
        successText.classList.add("reveal");
        setTimeout(() => {
            successText.classList.add( "visible");
        },100)
        buyButton.parentElement.appendChild(successText);

        buyButton.innerText = "checkout now";
        buyButton.classList.add("inverse");
        buyButton.addEventListener("click", () => {
            redirect("/checkout");
        })
    })
}

setupFavorites().catch((e) => {
    console.error("Setting up favorites went wrong: ", e);
});