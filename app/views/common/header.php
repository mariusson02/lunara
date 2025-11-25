<header>
    <div>
        <a class="navbar__logo" href="/">
            <img src="<?= ROOT ?>assets/images/logo_white.png" alt="Logo">
        </a>
        <button class="navbar__hamburger" id="hamburger-btn" aria-label="Toggle navigation">
            &#9776;
        </button>
    </div>
    <nav>
        <ul class="navbar navbar__items" id="hamburger-items">
            <li class="navbar__item effect-shine <?= $page == 'about' ? 'active' : ''?>"><a href="/about">_ About</a></li>
            <?php if(Middleware::isLoggedIn() && !Middleware::isAdmin()): ?>
                <li class="navbar__item effect-shine <?= $page == 'myNfts' ? 'active' : ''?>"><a href="/account/myNfts">_ My NFTs</a></li>
                <li class="navbar__item effect-shine <?= $page == 'favorites' ? 'active' : ''?>"><a href="/account/favorites">_ Favorites</a></li>
            <?php endif; ?>
            <li class="navbar__item effect-shine <?= $page == 'browse' ? 'active' : ''?>"><a href="/browse">_ Browse</a></li>
            <li class="navbar__checkout"><a href="/checkout">
                    <img src="<?= ROOT ?>assets/svg/checkout.svg" class="navbar__icon" alt="Checkout" />
                </a>
            </li>
            <?php if (Middleware::isLoggedIn()) : ?>
            <li class="navbar__dropdown">
                <img src="<?= ROOT ?>assets/svg/user.svg" class="navbar__icon" alt="user profile">
                <ul>
                    <li class="navbar__dropdown-item  effect-shine">
                        <a href="/account/edit">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff"><path d="M400-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM80-160v-112q0-33 17-62t47-44q51-26 115-44t141-18h14q6 0 12 2-8 18-13.5 37.5T404-360h-4q-71 0-127.5 18T180-306q-9 5-14.5 14t-5.5 20v32h252q6 21 16 41.5t22 38.5H80Zm560 40-12-60q-12-5-22.5-10.5T584-204l-58 18-40-68 46-40q-2-14-2-26t2-26l-46-40 40-68 58 18q11-8 21.5-13.5T628-460l12-60h80l12 60q12 5 22.5 11t21.5 15l58-20 40 70-46 40q2 12 2 25t-2 25l46 40-40 68-58-18q-11 8-21.5 13.5T732-180l-12 60h-80Zm40-120q33 0 56.5-23.5T760-320q0-33-23.5-56.5T680-400q-33 0-56.5 23.5T600-320q0 33 23.5 56.5T680-240ZM400-560q33 0 56.5-23.5T480-640q0-33-23.5-56.5T400-720q-33 0-56.5 23.5T320-640q0 33 23.5 56.5T400-560Zm0-80Zm12 400Z"/></svg>
                            My Account
                        </a>
                    </li>
                    <?php if (Middleware::isAdmin()) :?>
                    <li class="navbar__dropdown-item  effect-shine">
                        <a href="/admin">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff"><path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z"/></svg>
                            Admin Dashboard
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="navbar__dropdown-item  effect-shine">
                        <a href="/auth/logout">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                            Logout
                        </a>
                    </li>
                </ul>
            </li>
            <?php else : ?>
            <li><button class="navbar__item holo effect-shine" onclick="redirect('/auth/login')">Login</button></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<main>