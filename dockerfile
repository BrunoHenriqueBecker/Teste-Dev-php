# Imagem base com PHP 8.1 e extensões necessárias para o Laravel
FROM php:8.1-fpm

# Definir o diretório de trabalho
WORKDIR /var/www

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar os arquivos do projeto para o container
COPY . .

# Instalar as dependências do Laravel
RUN composer install --no-interaction

# Definir variáveis de ambiente para o Laravel
ENV APP_ENV=local
ENV APP_KEY=base64:YOUR_APP_KEY

# Permissões para o diretório de armazenamento
RUN chown -R www-data:www-data /var/www/storage

# Expor a porta 9000 para o servidor PHP-FPM
EXPOSE 9000

# Comando para iniciar o servidor PHP-FPM
CMD ["php-fpm"]
