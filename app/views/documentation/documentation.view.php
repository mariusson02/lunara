<canvas id="browse__bg"></canvas>
<div class="docs-container">
    <h1>Documentation</h1>

    <section>
        <h2>Inhalt</h2>
        <p>Die Website <strong>Lunara</strong> wurde für den fiktiven Kunden entwickelt, um eine immersive NFT-Erfahrung mit einem Weltraum-Thema zu bieten. Zielgruppe sind sowohl NFT-Enthusiasten als auch Personen, die sich für futuristisches Design interessieren.</p>
        <p>Ein Kunde betritt unsere Plattform und taucht sofort in eine futuristische, weltrauminspirierte Welt ein. Schon beim Scrollen über die Startseite wird er von einer minimalistischen, aber eleganten Ästhetik begrüßt. Die nahtlosen Animationen und der sanfte Farbwechsel in holografischen Verläufen schaffen eine Atmosphäre von Modernität und technologischem Fortschritt.</p>
        <p>Er entdeckt ein NFT, das seine Aufmerksamkeit erregt. Durch das interaktive 3D-Modell kann er es aus verschiedenen Blickwinkeln betrachten, während sich die Kamera dynamisch an seine Scrollbewegungen anpasst. Jede Sektion der Seite offenbart ihm weitere Details – von der Bedeutung des NFTs bis hin zu seiner Seltenheit und seinem Preis. Das klare, intuitive Interface lenkt ihn mühelos durch den Kaufprozess.</p>
        <p>Als er weiter nach unten scrollt, erreicht er den Footer der Seite. An diesem Punkt verharrt das 3D-Modell, als ob es sich im Raum verankert hätte – eine subtile, aber wirkungsvolle Designentscheidung, die für eine flüssige User Experience sorgt. Nachdem er das NFT erworben hat, erhält er eine stilvolle Bestätigung, die das Erlebnis abrundet und ihn in die exklusive Welt digitaler Sammlerstücke eintauchen lässt.</p>
    </section>

    <section>
        <h2>Ergebnisse der Recherche</h2>
        <p>Wir haben bestehende NFT-Plattformen analysiert, darunter:</p>
        <ul>
            <li><strong>OpenSea:</strong> Fokus auf umfangreiche NFT-Kataloge</li>
            <li><strong>Rarible:</strong> Community-gesteuerte Plattform</li>
            <li><strong>Foundation:</strong> Premium-Design und Benutzererfahrung</li>
            <li><strong>AstroNFT Everdome:</strong> futuristisches Design, interaktive Übergänge, parallaxartige Effekte für ein immersives Design</li>
        </ul>
    </section>

    <section>
        <h2>Allgemeines Seitenlayout</h2>
        <p>Das Layout wurde in Figma erstellt und umfasst:</p>
        <ul>
            <li><strong>Header:</strong> Navigationselemente und Logo</li>
            <li><strong>Seiteninhalt:</strong> Dynamischer Seiteninhalt (mit Unterstützung von ThreeJS Modellen)</li>
            <li><strong>Footer:</strong> Impressum und weitere Links</li>
        </ul>
        <img src="<?= ROOT ?>assets/images/wireframe.png" alt="Wireframing der Seiten">
        <p>Alternativ können Sie das Wireframe<a href="https://www.figma.com/design/JyfreHoSCQ0ukyHQW8bCM7/DWP2?node-id=0-1&t=l6m5t3v9tpAium1s-1" target="_blank">hier</a>anschauen</p>
    </section>

    <section>
        <h2>Design</h2>
        <p>Das Design basiert auf futuristischen Farben und klaren Schriftarten, um das Weltraum-Thema zu unterstützen.</p>
        <p>Unsere Plattform wurde mit einem klaren gestalterischen Konzept entwickelt: eine futuristische Vision, inspiriert vom Weltraum, kombiniert mit minimalistischer Eleganz.</p>
        <strong>Farbgestaltung</strong>
        <p>Die dominanten Farben Schwarz und Weiß verkörpern die Unendlichkeit und Klarheit des Universums. Während Schwarz für die unermessliche Tiefe des Kosmos steht, symbolisiert Weiß das Licht der Sterne und die Reinheit von Technologie und Innovation. Akzente setzen wir mit holografischen Farbverläufen, die an interstellare Reflexionen und moderne High-Tech-Oberflächen erinnern. Sie verleihen dem Design Dynamik und verstärken den futuristischen Look.</p>
        <strong>Simplicity vs. Complexity</strong>
        <p>Das Universum wirkt auf den ersten Blick einfach – eine scheinbar endlose Weite aus Dunkelheit und Licht. Doch hinter dieser Schlichtheit verbirgt sich eine komplexe, durchdachte Struktur. Diese Dualität haben wir in unser Design übertragen. Unsere Benutzeroberfläche ist bewusst minimalistisch gehalten, um eine intuitive und angenehme Nutzererfahrung zu ermöglichen. Gleichzeitig sind im Hintergrund ausgeklügelte Mechaniken aktiv, die für dynamische Animationen, sanfte Übergänge und eine interaktive Nutzerführung sorgen.</p>
        <strong>Interaktives Erlebnis</strong>
        <p>Die Implementierung einer 3D-Ansicht für NFTs hebt das Erlebnis auf eine neue Ebene. Durch die kameragesteuerte Scrollanimation fühlen sich Nutzer, als würden sie durch einen virtuellen Raum navigieren, in dem sie das Objekt ihrer Wahl aus jedem Blickwinkel erkunden können. Diese immersive Interaktion stärkt das Gefühl der Exklusivität und des technologischen Fortschritts, das unsere Plattform vermitteln möchte.</p>
        <strong>Flüssige Bewegung & Dynamik</strong>
        <p>Um den Eindruck von Schwerelosigkeit und Weite zu verstärken, setzen wir auf sanfte Animationen und geschmeidige Bewegungen. Elemente erscheinen allmählich im Sichtfeld, als würden sie aus der Dunkelheit des Alls auftauchen. Die Kamera reagiert organisch auf Scrollbewegungen, wodurch ein Gefühl von Tiefe und Lebendigkeit entsteht.</p>
    </section>

    <section>
        <h2>Beschreibung der Funktionalitäten</h2>
        <p>Die wichtigsten Funktionen:</p>
        <ul>
            <li>Browsen von NFTs</li>
            <li>Favorisieren von NFTs</li>
            <li>NFTs in den Warenkorb legen</li>
            <li>Account anlegen / einloggen</li>
            <li>NFTs kaufen / verkaufen</li>
            <li>Adminbereich zur Verwaltung von Inhalten</li>
        </ul>
    </section>

    <section>
        <h2>ER-Modell und relationales Modell</h2>
        <img src="<?= ROOT ?>assets/svg/Datenbank_ER.svg" alt="datenbank ER">
        <p>mit asynchronen Besprechungen zum Design :D</p>
    </section>

    <section>
        <h2>Rollenmodell</h2>
        <p>Das Rollenmodell umfasst folgende Benutzer:</p>
        <ul>
            <li><strong>Admin:</strong> Hat umfangreiche Bearbeitungsrechte, kann aber keine NFTs kaufen</li>
            <li><strong>User:</strong> Kann NFTs durchsuchen, favorisieren und kaufen/verkaufen</li>
            <li><strong>Guest:</strong> Kann NFTs durchsuchen und in den Warenkorb legen</li>
        </ul>
    </section>

    <section>
        <h2>Flussbild für Dateneingabe</h2>
        <p><em>Platzhalter für das Flussdiagramm</em></p>
    </section>

    <section>
        <h2>Reflexion</h2>
        <strong>Herausforderungen:</strong>
        <ul>
            <li>Umsetzung der Transaktionslogik</li>
            <li>Integration von Three.js</li>
            <li>Implementierung von Zugriffskontrollen für AJAX Requests</li>
            <li>Normalisierung der Größen der 3D Modelle</li>
        </ul>
        <strong>Known Bugs:</strong>
        <ul>
            <li><em>Admin kann favorisieren</em></li>
            <li>Zugriffskontrollen für AJAX Requests sind nicht hundertprozentig sauber umgesetzt</li>
        </ul>
        <strong>Projektmanagement:</strong>
        <ul>
            <li>Aufgabenverteilung wurde gemeinsam besprochen und effektiv umgesetzt</li>
            <li>Die Bearbeitung der Aufgaben erfolgte eher autark, bei Problemen oder Abschluss einer Aufgabe wurde dies mit der Gruppe kommuniziert</li>
            <li>Gitlab als Tool zur Aufgabenverwaltung und Kommunikation über Issues, Merge Requests und Kommentare</li>
        </ul>
    </section>
    <section>
        <h2>Aufgabenverteilung</h2>
        <table>
            <tr>
                <td>Anna</td>
                <td>
                    <p>Aufwandseinschätzung: 80hrs</p>
                    <p>Aufgabenbereiche</p>
                    <ul>
                        <li>Wireframing</li>
                        <li>Backend - Ausbau und Weiterentwicklung</li>
                        <li>Backend - Error Handling</li>
                        <li>Account/Admin page inkl. Darstellung und Backend</li>
                        <li>Frontend - Integration und Entwicklung mit ThreeJS</li>
                        <li>Detail und Explore Page</li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>Jannis</td>
                <td>
                    <p>Aufwandseinschätzung: 85hrs</p>
                    <p>Aufgabenbereiche</p>
                    <ul>
                        <li>Backend - ORM und MVC</li>
                        <li>Backend - Transactions für Kaufen und Verkaufen</li>
                        <li>Authorization and Authentication</li>
                        <li>Checkout Funktionalität inkl. Cookies</li>
                        <li>Modularisierung von ThreeJS Code</li>
                        <li>Browse Page</li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>Marius</td>
                <td>
                    <p>Aufwandseinschätzung: 80hrs</p>
                    <p>Aufgabenbereiche</p>
                    <ul>
                        <li>Backend - Datengenerierung und -pflege</li>
                        <li>Favorites inkl. Darstellung und Backendlogik</li>
                        <li>Design Auth-Pages (Login, Logout, Signup) und Anschluss an bestehendes Backend</li>
                        <li>Header- und Footerdesign inkl. Mobile View</li>
                    </ul>
                </td>
            </tr>
        </table>
    </section>

    <section>
        <h2>Installationshinweise</h2>
        <p>Die Website kann durch folgendes Setup installiert werden:</p>
        <ol>
            <li>Docker und Docker-Compose installieren</li>
            <li>Repository klonen und <code>./setup.sh</code> ausführen</li>
            <li>Auf <code>http://localhost</code> zugreifen</li>
        </ol>
    </section>

    <section>
        <h2>Zugangsdaten</h2>
        <table>
            <thead>
            <tr>
                <th>Account Type</th>
                <th>Admin</th>
                <th>User</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>
                    Username
                </th>
                <td>
                    admin
                </td>
                <td>
                    user
                </td>
            </tr>
            <tr>
                <th>
                    Passwort
                </th>
                <td>
                    admin
                </td>
                <td>
                    user
                </td>
            </tr>
            </tbody>

        </table>
    </section>
</div>

<script type="module" src="<?= ROOT ?>assets/js/browse.js"></script>