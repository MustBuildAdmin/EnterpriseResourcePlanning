pipeline{
    agent any
    environment {
        production_server="3.7.159.33"
    }

    stages{
        stage('Deploy to Production') {
            steps{
                //sh 'scp ${WORKSPACE}/* root@${production_server}:/var/www/html/EnterpriseResourcePlanning-1.1-Version/'
                sh 'rsync -vrzhe "ssh -o StrictHostkeyChecking=no" ${WORKSPACE}/* root@${production_server}:/var/www/html/EnterpriseResourcePlanning-1.1-Version/'
                'sudo rm -rf /var/www/html/erptest/*'
                'scp -r /var/lib/jenkins/workspace/TestEnv/* /var/www/html/erptest/'
                'cd /var/www/html/erptest/'
                'composer install --no-interaction'
                'sudo chmod -R 777 /var/www/html/'
            }
        }
    }
}
