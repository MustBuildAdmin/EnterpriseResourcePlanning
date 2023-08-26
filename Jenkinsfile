pipeline {
    agent any
    environment {
        production_server="http://13.234.199.245/"
    }

    stages{
        stage('Deploy to dev') {
            steps{
                sh 'sudo rm -rf /var/www/html/erpdev/*'
                sh 'scp -r /var/lib/jenkins/workspace/construction-dev/*  /var/www/html/erpdev/'
                sh 'cd /var/www/html/erpdev/'
                 sh 'composer install --no-interaction'
                 sh 'php artisan key:generate'
                 sh 'sudo chmod -R 777 /var/www/html/'
            }
        }
           stage('Deploy to Test') {
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
