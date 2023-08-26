pipeline {
    agent any
    stages{
        stage('Prepare Env') {
            steps{
                sh 'sudo apt-get install php-xml'
                sh 'sudo apt-get install php-mbstring'
                sh 'sudo apt-get install php-curl'
                sh 'sudo apt-get install php8.1-gd'
            }
        }.
        stage('AWS DevEnv') {
            steps{
                sh 'sudo rm -rf /var/www/html/erpdev/*'
                sh 'scp -r /var/lib/jenkins/workspace/construction-dev/*  /var/www/html/erpdev/'
                sh 'cd /var/www/html/erpdev/'
                 sh 'composer install --no-interaction'
                 sh 'php artisan key:generate'
                 sh 'sudo chmod -R 777 /var/www/html/'
            }
        }
           stage('AWS QC Env') {
            steps{
                sh 'sudo rm -rf /var/www/html/erptest/*'
                sh 'scp -r /var/lib/jenkins/workspace/construction-dev/*  /var/www/html/erptest/'
                sh 'cd /var/www/html/erptest/'
                 sh 'composer install --no-interaction'
                 sh 'php artisan key:generate'
                 sh 'sudo chmod -R 777 /var/www/html/'
            }
        }
       
    }

}
