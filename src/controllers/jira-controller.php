<?php

// var_dump($jiraConfiguration); die();
/*
 * Jira controller class to handle all Jira operations
 */
class JiraController extends ControllerBase
{
    public function getIssues()
    {
        global $jiraConfiguration;

        $parameters = array_merge((array) $jiraConfiguration, $_POST);

        $jiraUrl = $jiraConfiguration['base_url'] . '/rest/api/2/search?jql=project=' . $parameters['project'];
        if ($parameters['jql']) {
            $jiraUrl .= ' and ' . str_replace( "'", "", $parameters['jql']);
        }

        if (substr_count(strtolower($parameters['jql']), "order by") == 0 && substr_count(strtolower($parameters['jql']), "order%20by") == 0) {
            $jiraUrl .= ' order by priority';
        }
        // var_dump($jiraUrl); die();

        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $jiraUrl, [
            'auth' => [$jiraConfiguration['username'], $jiraConfiguration['password']]
        ]);
        return json_decode($res->getBody()->getContents(), true);
    }
}

return new JiraController($entityManager);
