pipeline {
    agent any
    stages{
            stage('SCM') {
                checkout scm
            }
            stage('SonarQube Analysis') {
                def scannerHome = tool 'SonarScanner';
                withSonarQubeEnv() {
                sh "${scannerHome}/bin/sonar-scanner"
                }
            }
            stage('AWS Demo Release') {
            steps{
                sh 'sudo chmod -R 777 /var/www/html/'
                sh 'sudo rm -rf /var/www/html/erpdemo/*'
                sh 'scp -r /var/lib/jenkins/workspace/demo-v0.1/*  /var/www/html/erpdemo/'
                sh 'cd /var/www/html/erpdemo/'
                sh 'composer install --no-interaction'
                sh 'composer install --optimize-autoloader --no-dev'
                sh 'php artisan key:generate'
                sh 'sudo chmod -R 777 /var/www/html/'
            }
        }    
       
    }

}
