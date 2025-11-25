    <canvas id="browse__bg"></canvas>

    <div class="browse__menu">
        <div class="browse__search">
            <div class="search__icon">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
            </div>
            <label for="browse-search"></label>
            <input
                    type="search"
                    name="q"
                    class="search__input"
                    id="browse-search"
                    placeholder="search..."
            />
        </div>
        <button class="browse__filter__toggle">
            <img src="<?= ROOT ?>assets/images/filter-icon.png" alt="Filter icon" />
        </button>
    </div>

    <div class="browse__filter">
        <div class="browse__filter__content">
            <div class="browse__filter__type">
                <label for="browse-type">type</label>
                <select name="browse-type" id="browse-type">
                    <option value="">All</option>
                    <?php foreach($types as $type): ?>
                        <option value="<?= $type ?>"><?= $type ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="browse__filter__price">
                <label for="browse-min-price">min price</label>
                <input
                        type="number"
                        id="browse-min-price"
                        name="min-price"
                        min="0.1"
                        step="0.1"
                />
            </div>
            <div class="browse__filter__price">
                <label for="browse-max-price">max price</label>
                <input
                        type="number"
                        id="browse-max-price"
                        name="max-price"
                        step="0.1"
                        min="0.1"
                />
            </div>
            <div class="browse__filter__available">
                <label for="browse-available" class="custom-checkbox-label">
                    available
                </label>
                <input type="checkbox" name="available" id="browse-available" class="custom-checkbox" />
            </div>
        </div>
    </div>

    <div id="browse__filter__error__container">
    </div>

    <div class="browse__container" id="items-container">
    </div>

    <div class="browse__container">
        <button id="load-more" class="secondary">Load more</button>
    </div>

    <div id="is-user-logged-in" style="display: none" data-logged-in="<?= Middleware::isLoggedIn() ? "true" : "false" ?>"></div>
    <script type="module" src="<?= ROOT ?>assets/js/browse-list.js" defer></script>
    <script type="module" src="<?= ROOT ?>assets/js/browse.js" defer></script>

