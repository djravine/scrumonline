<?php
// database configuration parameters
$conn = array(
    'dbname' => getenv('DB_DATABASE'),
    'user' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'host' => getenv('DB_HOST'),
    'driver' => 'pdo_mysql',
);

// This is used to create the join link
$host = getenv('BASE_URL');

// Google analytics id
$ga = 'GOOGLE-ANALYTICS';

$cardSets = [
    ['❔', '1', '3', '5', '8']
];

// Src tree for documentation linking from page
$src = "https://github.com/intellipharm-pty-ltd/scrumonline";

// Active ticketing plugins of the page
$plugins = [
    'JIRA'
];

// Configuration for the server side JIRA controller
$jiraConfiguration = [
    'base_url' => getenv('JIRA_BASE_URL'),
    'username' => getenv('JIRA_USERNAME'),
    'password' => getenv('JIRA_PASSWORD'),
    'project' => getenv('JIRA_PROJECT'),
    'jql' => getenv('JIRA_JQL'),
];
