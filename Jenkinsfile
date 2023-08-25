pipeline {
    agent any
    environment {
        production_server="http://13.234.199.245/"
    }

    stages{
        stage('Deploy to dev') {
            steps{
                'sudo rm -rf /var/www/html/erpdev/*'
                 'scp -r /var/lib/jenkins/workspace/construction_management/*  /var/www/html/erpdev/'
                'cd /var/www/html/erpdev/'
                 'composer install --no-interaction'
                 'php artisan key:generate'
                 'sudo chmod -R 777 /var/www/html/'
            }
        }
       
    }

}
