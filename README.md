
# API News

dev website - http://vps-40924.vps-default-host.net:7777/


## Download project
```
git clone https://github.com/v-e-y/hillel-test-3-news-board-api.git
```

## Turn on/run and prepare project

rename '.env.example' file to '.env' and fill it your environment data 

```
CMD: docker-compose up -d --build
CMD: docker container exec -it hillel_test_3_news_api_php /bin/bash
CMD: composer install
CMD: php artisan key:generate
CMD: php artisan migrate:refresh --seed
```

## API
[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/f08427ea8426203bf9a6?action=collection%2Fimport)


## Set CRON command for job(s)
```
[project_folder]/ * * * * * docker exec -t $(docker ps -qf "name=hillel_test_3_news_api_php") php artisan schedule:run >> /dev/null 2>&1
```

## Turn of/stop project
```
CMD: docker-compose down
```



Hey, let's build a simple news board API. 

We will start with a simple MVP. It will have a list of news with functionality to upvote and comment on them. Similar platform to [HackerNews](https://news.ycombinator.com/).

### **Functional Requirements**
- Create CRUD API to manage news posts. The post will have the next fields: title, link, creation date, amount of upvotes, author-name
- Posts should have CRUD API to manage comments on them. The comment will have the next fields: author-name, content, creation date
- There should be an endpoint to upvote the post
- We should have a recurring job running once a day to reset post upvotes count

### **Technical Requirements**
- Code should be written with PHP 8
- REST API should be Laravel or Symfony based
- API should be well documented with Postman collection. Make sure to use [Postman environments and variables](https://learning.postman.com/docs/postman/variables-and-environments/variables/#understanding-variables-and-environments), so you can switch between local API and deployed version. Add Postman collection link to the README
- API has to run as a Docker container. API + Postgres / MySQL should be launched with docker-compose
- Necessary to make sure that code passes [PSR-12](https://www.php-fig.org/psr/psr-12/) checks using [CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
- The project should have clear README with steps to run it
- The code should be clean, passing linter checks and simple to understand. Code quality matters a lot
- Deploy API for testing to [Heroku](https://www.heroku.com/) or similar service. Add deployment link to the README

### **Conditions**
- Task usually takes **from 4 to 6 hours**. If you need more time, you're good to take it and it's appreciated, but results should be sent **no later than 48 hours after the start**
- Skills to write clean business logic and apply best practices are important
- The challenge code should be pushed to the **GitHub** repository.

### Follow Up
If you have any questions regarding the task, contact our HR manager.
Cheers! 😊


news-upvoters
news_id
user_id