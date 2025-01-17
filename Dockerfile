# Usa uma imagem base oficial do PHP
FROM php:8.1-apache

# Instala dependências necessárias
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Habilita o módulo Apache fornecido
RUN a2enmod rewrite

# Copia o código do seu projeto para o diretório do servidor
COPY . /var/www/html/

# Define o diretório de trabalho
WORKDIR /var/www/html

# Permite que o Apache tenha permissões para acessar os arquivos
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta 80
EXPOSE 80

# Comando padrão para iniciar o servidor Apache
CMD ["apache2-foreground"]