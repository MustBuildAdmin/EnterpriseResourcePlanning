pipeline {
    environment {
        DISABLE_AUTH = 'true'
        DB_ENGINE    = 'DB_CONNECTION'
    }
    agent any
    stages {
        stage ("install packages") {
            steps { 
               echo "Database engine is ${DB_ENGINE}"
               echo "DISABLE_AUTH is ${DISABLE_AUTH}"
               sh 'printenv'
               sh 'composer install --no-interaction --optimize-autoloader --no-dev'
               sh 'cp .env.example .env'
               sh 'php artisan key:generate'
               sh 'php artisan migrate'
            } 
        }
        stage("Build") {
            steps {
                sh 'sudo chmod -R 777 /var/lib/jenkins/workspace/demo-v0.1/'
            }
        }
       
    }
}
