pipeline {
  agent any
  stages {
    stage('build') {
      steps {
        build 'test'
      }
    }
    stage('deploy') {
      steps {
        writeFile(file: 'asal', text: 'test', encoding: 'utf-8')
      }
    }
  }
}