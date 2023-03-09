pipeline{
    agent any
    environment {
        production_server="3.7.159.33"
    }

    stages{
        stage('Deploy to Production') {
            steps{
                sh 'scp ${WORKSPACE}/* root@${production_server}:/var/www/html/EnterpriseResourcePlanning-1.1-Version/'
            }
        }
    }
}
