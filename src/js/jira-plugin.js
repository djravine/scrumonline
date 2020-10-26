/*globals scrum */

// Add a plugin to load tickets from local JIRA server
scrum.sources.push({
  // Fixed properties and methods
  name: "JIRA",
  position: 3,
  view: "templates/jira_source.html",
  feedback: false,
  base_url: jira_base_url,
  project: jira_project,
  jql: jira_jql,
  // jql: 'issuetype=story and status=backlog',
  // Feedback call for completed poll
  completed: function(result) {
  },
  
  // Custom properties and methods
  loaded: false,
  issues: [],
  issue: {},
  event: ['poll', 'start', 'JIRA'],

  load: function() {
    var self = this;

    var queryParameters = $.param({
      base_url: this.base_url,
      project: this.project,
      jql: this.jql
    });

    this.parent.$http({
      url: '/api/jira/getIssues',
      method: 'POST',
      data: queryParameters,
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
      .then(function (response) {
        var data = response.data;

        if (!data || !data.issues) {
          self.error = 'Can\'t load Jira issues, check configuration';
        } else {
          var converter = new showdown.Converter();
          // Convert JIRA format to Markdown and then to HTML
          response.data.issues.forEach(function(issue) {
            var md_desc = J2M.toM(issue.fields.description || '');
            issue.fields.description = converter.makeHtml(md_desc.trim());
            var md_accr = J2M.toM(issue.fields.customfield_11482 || '');
            issue.fields.customfield_11482 = converter.makeHtml(md_accr.trim());
            var md_imno = J2M.toM(issue.fields.customfield_11483 || '');
            issue.fields.customfield_11483 = converter.makeHtml(md_imno.trim());
            var md_usca = J2M.toM(issue.fields.customfield_11486 || '');
            issue.fields.customfield_11486 = converter.makeHtml(md_usca.trim());
          });
          self.issues = response.data.issues;
          self.issue = self.issues[0];
          self.jira_base_url = jira_base_url;
          self.loaded = true;
        }
      });
  },
  reload: function() {
    this.loaded = false;
  }
});
