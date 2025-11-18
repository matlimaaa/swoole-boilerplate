FROM phpswoole/swoole:4.8-alpine

WORKDIR /var/www

COPY . .

EXPOSE 9501

CMD ["php", "./04-parallel-coroutines/server.php"]
