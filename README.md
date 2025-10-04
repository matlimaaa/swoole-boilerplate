# 🚀 Swoole Study Boilerplate

Este repositório contém exemplos práticos sobre o [**Swoole**](https://wiki.swoole.com/en/#/).

## 📦 Setup

Temos multiplos exemplos evolutivos dentro desse repositório. Para executarmos cada projeto e testar, devemos seguir os passos:

1. Atualizar o **Dockerfile**.
    1. mudarmos o trecho de comando (CMD) de **"./02-http-routes/server.php"** para **"./01-http-basic/server.php"**
2. Construir imagem & dar UP no serviço:
  ```bash
    docker-compose down && docker-compose up -d --build
  ```
3. Usar os recursos via [localhost](http://localhost:9501/)
