pipeline{
    agent any
    environment {
        production_server="http://13.234.199.245/"
    }

    stages{
        stage('Deploy to dev') {
            steps{
                sudo rm -rf /var/www/html/erpdev/*
                scp -r /var/lib/jenkins/workspace/TestEnv/* /var/www/html/erpdev/
                cd /var/www/html/erpdev/
                composer install --no-interaction
                sudo chmod -R 777 /var/www/html/
            }
        }
          stage('Deploy to test') {
            steps{
                sudo rm -rf /var/www/html/erptest/*
                scp -r /var/lib/jenkins/workspace/TestEnv/* /var/www/html/erptest/
                cd /var/www/html/erptest/
                composer install --no-interaction
                sudo chmod -R 777 /var/www/html/
            }
        }
    }
}
