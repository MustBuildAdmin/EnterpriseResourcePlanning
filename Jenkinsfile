pipeline {
    agent any
    stages {
        stage("Build") {
            steps {
                sh 'sudo chmod -R 777 /var/www/html/'
                sh 'sudo rm -rf /var/www/html/erpdemo/*'
                sh 'scp -r /var/lib/jenkins/workspace/demo-v0.1/*  /var/www/html/erpdemo/'
                sh 'cd /var/www/html/erpdemo/'
                sh 'php --version'
                sh 'composer install --no-interaction --optimize-autoloader --no-dev'
                sh 'composer --version'  
                sh 'php artisan key:generate'
                sh 'sudo chmod -R 777 /var/www/html/'
            }
        }
       
    }
}
