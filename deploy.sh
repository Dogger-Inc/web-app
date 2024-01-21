#!/bin/sh
set -e

#vendor/bin/phpunit

(git push) || true

git checkout prod

git pull origin prod

git merge master

git push origin prod

git checkout master
