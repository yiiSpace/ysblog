<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/19
 * Time: 15:53
 */

// All Deployer recipes are based on `recipe/common.php`.
// require 'recipe/symfony.php';
require 'recipe/yii2-app-basic.php';

// Define a server for deployment.
// Let's name it "prod" and use port 22.
server('prod', 'host', 22)
    ->user('name')
    ->forwardAgent() // You can use identity key, ssh config, or username/password to auth on the server.
    ->stage('production')
    ->env('deploy_path', '/your/project/path'); // Define the base path to deploy your project to.

// Specify the repository from which to download your project's code.
// The server needs to have git installed for this to work.
// If you're not using a forward agent, then the server has to be able to clone
// your project from this repository.
set('repository', 'git@github.com:yiiSpace/ysblog.git');