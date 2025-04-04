<h1> Library management system </h1>

This project is initialised as a code kata to learn domain driven design.
it is written in Laravel 8 
and runs in php 8.3

### install guide: 

Generate a ssl certificate by the following commands:
Windows:
`"C:\Program Files\Git\usr\bin\openssl.exe" genpkey -algorithm RSA -out /etc/nginx/conf.d/ssl/private.key`
`"C:\Program Files\Git\usr\bin\openssl.exe" openssl req -new -key /etc/nginx/conf.d/ssl/private.key -out /etc/nginx/conf.d/ssl/certificate.csr`
`"C:\Program Files\Git\usr\bin\openssl.exe" openssl req -x509 -days 365 -key /etc/nginx/conf.d/ssl/private.key -in /etc/nginx/conf.d/ssl/certificate.csr -out /etc/nginx/conf.d/ssl/certificate.crt`

Run docker-compose up and check if the `.env` is created.
docker exec -it app sh and execute `php artisan key:generate;php artisan migrate;php artisan db:seed --class=ProductSeeder`

### Acceptance Criteria
We have an order system and a stock system. The order system is responsible for the following actions:
- A user can view his order and his order lines. ✔
- A user can check the total price of his order.
- A user can rent a product for a certain period which creates an order.
- A customer can return a rented book if that rented book is his own book.
- If a customer has not returned the book within the time range, he gets fined a dollar foreach week he did not return it.
- We want to notify the customer each week another dollar has been added to his order.
- If the stock of the shop is full, we want to return 3 books of that title, of another one of that book then returns just only add 1 (so 4).
- The shop should have a maximum of 8 books in total in the stock.
- The warehouse drives by only once a week to retrieve all the books that have been pilled up on the counter of the shop.
