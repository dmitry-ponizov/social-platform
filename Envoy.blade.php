@servers(['localhost' => '127.0.0.1'])

@story('deploy')
    git
    composer
    npm
    artisan
@endstory

@task('git')
    git pull
@endtask

@task('composer')
    composer install
@endtask

@task('npm')
    rm -rf node_modules
    npm install
    npm run production
@endtask

@task('artisan')
    php artisan cache:clear
    php artisan config:clear
    php artisan view:clear
    php artisan migrate
    {{--php artisan db:seed  --class=""--}}
@endtask
