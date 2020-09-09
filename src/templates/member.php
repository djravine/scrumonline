<?php

require_once __DIR__ . "/../../vendor/autoload.php";

// Load .env
if (file_exists('../.env')) {
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
  $dotenv->load();
  $dotenv->required([
    'BASE_URL',
    'DB_HOST',
    'DB_PORT',
    'DB_DATABASE',
    'DB_USERNAME',
    'DB_PASSWORD',
    'JIRA_BASE_URL',
    'JIRA_USERNAME',
    'JIRA_PASSWORD',
    'JIRA_PROJECT',
    'JIRA_JQL'
  ]);
}
include __DIR__ . "/../config.php";

?>

<div class="panel panel-default">
  <div class="panel-heading">
    <div class="row">
      <div class="col-xs-12">
        <button type="button" class="btn btn-large btn-danger pull-right" aria-label="Close" ng-click="member.leave()"> 
          <span aria-hidden="true"><strong>X</strong></span> 
        </button>
        <h2 class="issue-heading">
          <a ng-href="{{member.topicUrl}}" target="_blank">
            <img class="priority" ng-src="{{member.priorityiconurl}}" title="{{member.priorityname}}" alt="{{member.priorityname}}" />
            <span ng-bind-html="member.topic"></span>
          </a>
        </h2>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <th scope="row">Description</th>
          <td style="white-space: pre-line" ng-bind-html="member.description"></td>
        </tr>
        <tr>
          <th scope="row">Acceptance</th>
          <td style="white-space: pre-line" ng-bind-html="member.customfield_11482"></td>
        </tr>
        <tr>
          <th scope="row">Implementation</th>
          <td style="white-space: pre-line" ng-bind-html="member.customfield_11483"></td>
        </tr>
        <tr>
          <th scope="row">Use Cases</th>
          <td style="white-space: pre-line" ng-bind-html="member.customfield_11486"></td>
        </tr>
      <tbody>
    </table>
  </div>
  <div class="panel-footer">
    <div class="row">
      <div class="col-lg-2 col-md-3 col-xs-4" ng-repeat="card in member.cards">
        <div class="card-container">
          <div class="card selectable" ng-class="{active: card.active, confirmed: card.confirmed}" ng-click="member.selectCard(card)">
            <div class="inner">
              <span class="card-label" ng-bind-html="card.value"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- <div class="row">
  <article class="col-xs-12 col-lg-10 col-lg-offset-1">
  <h3>How to:</h3>
  <p>The panel at the top displays the current feature for estimation. The description below might help in deciding on an estimate for its complexity. 
    The panel is updated automatically everytime your scrum master starts a new poll. Once he did the server will accept estimates and you can start voting.
  </p>
  <p>Place your vote by selecting one of the cards above. The card will be highlighted red to indicate that the server is processing your vote. Once it did
    the card will be highlighted green and you should see a card with a <strong>?</strong> above your name on the master view. If it stays red that means
    the server rejected your vote. This is mostly the cause when you tried to vote outside of an open estimation poll. Either by voting before the scrum
    master started the session or after everyone voted.</p>
  <p>
    Until everyone voted you can change your vote. You can directly select a new card or, if you need more time to think, click your current card again to
    undo your selection and take back your vote. The poll will now remain open until you place a new estimate for the current feature.
  </p>
  <p>After all your team members voted on the current story, the poll is closed and the cards on the master view are now flipped. You can no longer vote on
    this session until the master restarts the estimation. If your vote on the master view is highlighted in red, it means you either gave the highest or
    lowest estimation. In that case explain the decision to you team members. After all arguments were heared your scrum master or product owner can start
    a new poll until you reach a consensus or verbally agree on a value withot voting again.</p>
</div> -->
