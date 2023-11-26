pipeline {
    environment {
        DISABLE_AUTH = 'true'
        DB_ENGINE    = DB_CONNECTION
    }
    agent any
    stages {
        stage ("install packages") {
            steps { 
               sh 'composer install --no-interaction --optimize-autoloader --no-dev'
               sh 'cp .env.example .env'
               sh 'php artisan key:generate'
            } 
        }
        stage("Build") {
            steps {
                sh 'sudo chmod -R 777 /var/lib/jenkins/workspace/demo-v0.1/'
            }
        }
       
    }
}
