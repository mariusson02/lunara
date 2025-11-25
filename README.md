## About Lunara

Lunara is a university project (student team project) implementing a PHP-based web application that showcases planet pages, a shop for items and NFTs, user authentication, favorites, and a simple admin area. It was created as a collaborative project by a three-person student team for a university course.

## My Contributions

I worked on this project as part of the team. The project was developed collaboratively by three students; the following lists my personal contributions for portfolio purposes.

- Implementing backend data generation and maintenance (data seeding and DB updates).
- Implementing the favorites feature (favoriting/unfavoriting NFTs) including backend logic and frontend representation.
- Designing and implementing the authentication pages (`login`, `logout`, `signup`) and integrating them with the backend.
- Designing the site header and footer, including mobile views and responsive behaviour.

## Setup Lunara locally
1. clone this repository
2. run `./setup.sh` in the root
   - this should run postgres and apache and initialize the database tables
3. access lunara at `localhost`


## Credentials (example)

Admin account:
- Username: `admin`
- Password: `admin`

User account:
- Username: `user`
- Password: `user`


## Roles
- Guest (can browse and put nfts into the checkout cart)
- User (can do everything besides the admin features)
- Admin (cannot buy or favor nfts but everything else)


## Error-Handling: `start-web.sh` Script Issues

### Problem: Web Container Fails to Start Due to Line Breaks

**Cause:**  
The `start-web.sh` script, used to start the web container, fails due to Windows Line breaks. This issue may occur in the following cases:
- The `start-web.sh` script has been modified.
- The repository has been freshly cloned.

### Solution

On a Unix-based system, run  `dos2unix ./start-web.sh` in the root folder of this repository.
Or do it manually on a Unix-based system like this:
1. **Remove Line Breaks:**  
   Clean up all line breaks in the `start-web.sh` script to ensure consistency.
2. **Restart the Docker Container**
3. **Restore Line Breaks (Optional)**

#### Note: This issue only occurs when the `start-web.sh` script is modified or the repository is freshly cloned.

---

## Setup Lunara locally
1. clone this repository
2. run ./setup.sh in the root
   - this should run postgres and apache and initialize the database tables
3. access lunara at localhost


## Credentials

Admin account:
- Username: admin
- Password: admin

User account:
- Username: user
- Password: user


## Roles
- Guest (can browse and put nfts into the checkout cart)
- User (can do everything besides the admin features)
- Admin (cannot buy or favor nfts but everything else)


## Error-Handling: `start-web.sh` Script Issues

### Problem: Web Container Fails to Start Due to Line Breaks

**Cause:**  
The `start-web.sh` script, used to start the web container, fails due to Windows Line breaks. 
This issue may occur in the following cases:
- The `start-web.sh` script has been modified.
- The repository has been freshly cloned.

### Solution

On a Unix-based system, run  `dos2unix ./start-web.sh` in the root folder of this repository.
Or do it manually on a Unix-based system like this:
1. **Remove Line Breaks:**  
   Clean up all line breaks in the `start-web.sh` script to ensure consistency:
2. **Restart the Docker Container**
3. **Restore Line Breaks (Optional)**


#### Note: This issue only occurs when the `start.web.sh` script is modified or the repository is freshly cloned.# lunara
