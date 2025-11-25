<canvas id="aboutCanvas"></canvas>
<div class="sidebar"></div>
<div class="about__main">
    <section id="about">
        <div>
            <h1 class="about__title reveal"><span>Astro NFTs</span></h1>
            <p class="reveal">Welcome to Lunara, where the mysteries of the universe meet the innovation of blockchain.
                Our platform is dedicated to offering exclusive, high-fidelity 3D models of interstellar objects as NFTs.
                From shimmering nebulae to distant exoplanets and imagined spacecraft, every piece we create merges artistic mastery with cutting-edge technology.</p>
            <img src="<?= ROOT ?>assets/images/planet.png" alt="holographic planet" class="reveal">
            <p class="reveal">What sets us apart? It’s our relentless commitment to detail and authenticity.
                Each NFT is more than a digital asset—it’s a gateway to the cosmos, meticulously designed for collectors, dreamers, and space enthusiasts alike.</p>
            <button class="about__button holo reveal" onclick="redirect('/auth/signup')">Register now</button>
        </div>
        <div class="about__media">
            <video autoplay loop muted>
                <source src="<?= ROOT ?>assets/videos/astronaut.mov" type="video/mp4; codecs='hvc1'">
                <source src="<?= ROOT ?>assets/videos/astronaut.webm" type="video/webm">
            </video>
        </div>
    </section>
    <section id="mission">
        <h1 class="about__title reveal"><span>Our Mission</span></h1>
        <div>
            <p class="reveal">At Lunara, we believe in the power of imagination and the boundless beauty of the universe.
                Our mission is to bring the awe-inspiring vastness of space closer to you through art and innovation.</p>
            <p class="reveal">Every NFT in our collection is a story crafted with passion—a hyper-detailed 3D model that combines astronomical
                accuracy with creative interpretation. By merging technology with artistic vision, we aim to inspire wonder and
                expand the possibilities of digital ownership.</p>
        </div>
        <button class="about__button holo reveal" onclick="redirect('/browse')">Browse through our NFTs</button>
    </section>
    <section id="chooseUs">
        <h1 class="about__title reveal"><span>Why Choose Us</span></h1>
        <div class="chooseUs__content">
            <div class="chooseUs__column">
                <div class="chooseUs__row reveal">
                    <p>A Cosmic Experience Like No Other</p>
                    <p>We’re not just selling NFTs; we’re offering a journey into the stars. Our collections are designed to spark curiosity
                    and connect collectors with the grandeur of the universe.</p>
                </div>
                <div class="chooseUs__row reveal">
                    <p>Sustainability at Heart</p>
                    <p>We’re committed to a sustainable future. By using eco-conscious blockchain technologies, we ensure that exploring
                    the digital cosmos doesn’t come at the expense of our planet.</p>
                </div>
            </div>
            <div class="chooseUs__column">
                <div class="chooseUs__row reveal">
                    <p>Community First</p>
                    <p>Our marketplace is more than a platform; it’s a hub for like-minded individuals. Join us to connect, share, and explore the universe together.</p>
                </div>
                <div class="chooseUs__row">
                    <button class="about__button holo reveal" onclick="redirect('/auth/signup')">Start your journey now!</button>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="module" src="<?= ROOT ?>assets/js/about.js"></script>