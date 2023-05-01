pipeline{
    agent any
    environment {
        production_server="http://13.234.199.245/"
    }

    stages{
        stage('Deploy to dev') {
            steps{
                sh 'sudo rm -rf /var/www/html/erpdev/*'
                sh 'scp -r /var/lib/jenkins/workspace/TestEnv/* /var/www/html/erpdev/'
                sh 'cd /var/www/html/erpdev/'
                sh 'composer install --no-interaction'
                sh 'sudo chmod -R 777 /var/www/html/'
            }
        }
          stage('Deploy to test') {
            steps{
                sh 'sudo rm -rf /var/www/html/erptest/*'
                sh 'scp -r /var/lib/jenkins/workspace/TestEnv/* /var/www/html/erptest/'
                sh 'cd /var/www/html/erptest/'
                sh 'composer install --no-interaction'
                sh 'sudo chmod -R 777 /var/www/html/'
            }
        }
        stage('Deploy to Staging') {
            steps{
                sh 'sudo cd var/www/html/mkdir erpstage'
                sh 'sudo rm -rf /var/www/html/erpstage/*'
                sh 'scp -r /var/lib/jenkins/workspace/TestEnv/* /var/www/html/erpstage/'
                sh 'cd /var/www/html/erpstage/'
                sh 'composer install --no-interaction'
                sh 'sudo chmod -R 777 /var/www/html/'
            }
        }
    }
}
