pipeline {
    agent any
    stages {
        stage("Checkout"){
            steps {
                script{
                 git branch: "develop", credentialsId:"github-cred" , url: "git@github.com:MustBuildAdmin/EnterpriseResourcePlanning.git"
            }
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
