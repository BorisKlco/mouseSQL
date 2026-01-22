FROM nginx:stable-alpine

# Remove default nginx config
RUN rm /etc/nginx/conf.d/default.conf

# Copy your config file into the image
COPY default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html
COPY ./src .