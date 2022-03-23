<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

# Iniciando o projeto

- SO Linux Ubuntu 20.04
- PHP 7.4.27 
- laravel 7.0

Iniciei com `git flow init`

`sudo chmod -R 777 storage`

> Nome do database: app_4bb61698
- CREATE DATABASE `app_4bb61698` /*!40100 COLLATE 'utf8mb4_general_ci' */;

### Comandos iniciais:
```
composer install
```

#### Obs: Renomear o arquivo .env.example caso não crie automatico.

# Para gerar a key da aplicação (.env)
`php artisan key:generate`

# Executa a criação das migrations
`php artisan migrate`

# Rollback - migrations (se necessário)
`php artisan migrate:rollback`

### POSTMAN
```
/postman_collection.json
```

### Rotas
<table>
  <tr>
    <th>Tipo</th>
    <th>Rota</th>
    <th>Método</th>
  </tr>
  <tr>
    <td>GET | HEAD</td>
    <td>api/history</td>
    <td>history.index</td>
  </tr>
  <tr>
    <td>GET | HEAD</td>
    <td>api/products</td>
    <td>products.index</td>
  </tr>
  <tr>
    <td>POST</td>
    <td>api/products</td>
    <td>products.store</td>
  </tr>
  <tr>
    <td>GET | HEAD</td>
    <td>api/products/{product}</td>
    <td>products.show</td>
  </tr>
  <tr>
    <td>PUT | PATCH</td>
    <td>api/products/{product}</td>
    <td>products.update</td>
  </tr>
  <tr>
    <td>DELETE</td>
    <td>api/products/{product}</td>
    <td>products.destroy</td>
  </tr>
</table>

## Usei para teste um gerador de SKU

`binary-cats/laravel-sku`