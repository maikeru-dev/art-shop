#!/bin/bash

# You need PHP, Node + NPM (postcss, postcsscli, autoprefixer), and SASS (dart/nodejs) installed to develop.
php -S localhost:8080 &
npx postcss assets/css/input/*.css --use autoprefixer -w -d assets/css/output/ &
sass -w assets/css/input/styles-saas.scss assets/css/input/styles.css &
wait
