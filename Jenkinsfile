pipeline {
    agent any
    stages{
           stage('AWS QC Env') {
            steps{
                sh 'sudo rm -rf /var/www/html/erptest/*'
                sh 'scp -r /var/lib/jenkins/workspace/test-v1/*  /var/www/html/erptest/'
                sh 'cd /var/www/html/erptest/'
                 sh 'composer install --no-interaction'
                 sh 'php artisan key:generate'
                 sh 'sudo chmod -R 777 /var/www/html/'
            }
        }
       
    }
}