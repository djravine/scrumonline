<?php
// database configuration parameters
$conn = array(
    'dbname' => 'scrum_online',
    'user' => 'root',
    'password' => 'passwd',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);

// This is used to create the join link
$host = "https://scrumonline.local";
$host = "http://10.7.129.29:8080";

// Google analytics id
$ga = 'GOOGLE-ANALYTICS';
  
$cardSets = [
    ['1', '3', '5', '8']
];

// Src tree for documentation linking from page
$src = "https://github.com/Toxantron/scrumonline/tree/master";

// Active ticketing plugins of the page
$plugins = [
    'JIRA'
];

// Configuration for the server side JIRA controller
$jiraConfiguration = [
    'base_url' => 'https://intellipharm.atlassian.net',
    'username' => 'adan.rehtla@intellipharm.com.au',
    'password' => '',
    'project' => 'NS',
    'jql' => '"Story Points" = empty and ( sprint != "Story Graveyard" and sprint NOT IN openSprints() or sprint = empty ) and issuetype = "Story" and status = "To Do"',
];
