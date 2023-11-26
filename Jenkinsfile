pipeline {
    agent any
    stages {
        stage("workspace clean"){
            steps {
               cleanWs()
             }
        }
        stage("Build") {
            steps {
                sh 'composer install --no-interaction --optimize-autoloader --no-dev'
                sh 'cp .env.example .env'
                sh 'php artisan key:generate'
                sh 'sudo chmod -R 777 /var/lib/jenkins/workspace/demo-v0.1/'
            }
        }
       
    }
}
