#!/bin/sh

echo "Starte Setup der Datenbank..."
if [ -f ./app/core/setup-db.php ]; then
    php ./app/core/setup-db.php
else
    echo "setup-db.php nicht gefunden!"
    exit 1
fi

npm install

( npm run build ) &

exec apache2-foreground