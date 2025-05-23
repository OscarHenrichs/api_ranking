#!/bin/sh

if [ ! -d "/var/www/html/.git" ]; then
  if [ -z "$GIT_REPO" ]; then
    echo "No GIT_REPO environment variable set"
  else
    echo "Cloning repository $GIT_REPO"
    rm -rf /var/www/html/*
    git clone --branch ${GIT_BRANCH:-main} $GIT_REPO /var/www/html
    chown -R www-data:www-data /var/www/html
  fi
else
  echo "Repository already exists, skipping clone"
fi

exec apache2-foreground
