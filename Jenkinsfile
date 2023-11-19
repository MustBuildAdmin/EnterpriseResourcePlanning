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
                sh 'php artisan migrate'
                sh 'sudo chmod -R 777 /var/www/html/'
            }
        }

        stage("Unit test") {
            steps {
                sh 'php artisan test'
            }
        }
        stage('SonarQube Analysis') {
            def scannerHome = tool 'SonarScanner';
            withSonarQubeEnv() {
            sh "${scannerHome}/bin/sonar-scanner"
            }
        }
        stage("Code coverage") {
            steps {
                sh "vendor/bin/phpunit --coverage-html 'reports/coverage'"
            }
        }
       stage('SonarQube Analysis') {
             environment {
                SCANNER_HOME = tool 'SonarQubeScanner'
                ORGANIZATION = "igorstojanovski-github"
                PROJECT_NAME = "igorstojanovski_jenkins-pipeline-as-code"
            }
            withSonarQubeEnv('SonarCloudOne') {
             sh '''$SCANNER_HOME/bin/sonar-scanner -Dsonar.organization=$ORGANIZATION \
                -Dsonar.java.binaries=build/classes/java/ \
                -Dsonar.projectKey=$PROJECT_NAME \
                -Dsonar.sources=.'''
           }
    }
}
