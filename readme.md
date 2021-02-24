# Test project "Newspaper"

**Task**

Create Rest API in Laravel, PostreSQL database.

The API should provide the ability to:
- Receive news list (with filters)
- Create news
- Mark news with tags.

You should realize the authentication (registration, login).
Fill the database with news through seeds.
Use the policies for access to actions. Also use validation for requests payload and use JSON-resourse.
Make some tests.

**Install**

```
git clone https://github.com/RFContracts/newspaper.git
cd newspaper
docker-compose up --build --force-recreate
```

**Run tests**

```
docker exec -it newspaper_app bash
php vendor/bin/phpunit
```
