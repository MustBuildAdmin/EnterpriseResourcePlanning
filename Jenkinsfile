pipeline {
    agent any
    stages {
        stage("Build") {
            steps {
                git 'https://github.com/MustBuildAdmin/EnterpriseResourcePlanning.git'
                sh 'composer install --no-interaction --optimize-autoloader --no-dev'
                sh 'cp .env.example .env'
                sh 'php artisan key:generate'
                sh 'sudo chmod -R 777 /var/www/html/'
            }
        }
       
    }
}
