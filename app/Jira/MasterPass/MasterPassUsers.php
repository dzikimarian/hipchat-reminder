<?php
namespace App\Jira\MasterPass;

use JiraRestApi\Group\GroupService;

use JiraRestApi\Issue\IssueService;

class MasterPassUsers
{
    private $groupService;
    private $projectService;
    private $issueService;

    public function __construct(GroupService $groupService, IssueService $issueService)
    {
        $this->groupService = $groupService;
        $this->issueService = $issueService;
    }

    public function getFreeUsers()
    {
        $queryParam = [
            'groupname' => 'jira-developers-masterpass',
            'includeInactiveUsers' => false,
            'startAt' => 0,
            'maxResults' => 100,
        ];

        $allUsersResult = $this->groupService->getMembers($queryParam);
        $freeUsers = [];
        foreach ($allUsersResult->values as $user) {
            $freeUsers[$user->key] = $user;
        }

        $jql = 'category = MasterPass  AND status not in( Done, "To Do", "Waiting for review" ) AND (Sprint in openSprints() OR project = "MasterPass Hardening")';
        $issuesInCurrentSprintResult = $this->issueService->search($jql, 0, 200);

        foreach ($issuesInCurrentSprintResult->issues as $issue){
            unset($freeUsers[$issue->fields->assignee->key]);
        }

        return $freeUsers;
    }




}