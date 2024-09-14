# Usar uma imagem base do PHP com Apache
FROM php:7.2-apache

# Instalar dependências
RUN docker-php-ext-install pdo pdo_mysql

# Instalar Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Configurar o diretório da aplicação
WORKDIR /var/www/html

# Copiar o código da aplicação
COPY . .

# Cria as pastas necessárias para o Laravel
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache

# Dar permissão ao diretório de cache e logs
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expor a porta 80
EXPOSE 80

# Rodar o servidor Apache
CMD ["apache2-foreground"]
