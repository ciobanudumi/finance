import { gql } from '@apollo/client';

export const TASK_SETS_OVERVIEW_QUERY = gql`
  query GetTaskSets(
    $page: Int!
    $itemsPerPage: Int!
    $taskSetOrder: String
    $taskSetPlanned: Boolean
    $taskSetAssignee: Boolean
    $taskSetTaskCompany: String
    $taskSetStatus: String
    $taskSetTaskRegion: String
    $taskSetTaskType: String
  ) {
    taskSets(
      page: $page
      itemsPerPage: $itemsPerPage
      taskSetOrder: $taskSetOrder
      taskSetPlanned: $taskSetPlanned
      taskSetAssignee: $taskSetAssignee
      taskSetTaskCompany: $taskSetTaskCompany
      taskSetStatus: $taskSetStatus
      taskSetTaskType: $taskSetTaskType
      taskSetTaskRegion: $taskSetTaskRegion
    ) {
      collection {
        id
        status
        assignee {
          id
          name
        }
        planned
        tasks {
          collection {
            id
            taskType
            region
            status
            company {
              name
            }
          }
        }
      }
      paginationInfo {
        itemsPerPage
        lastPage
        totalCount
      }
    }
  }
`;

export const GET_TASK_SET_ITEM_QUERY = gql`
  query GetTaskSet($id: ID!) {
    taskSet(id: $id) {
      id
      status
      assignee {
        id
        name
      }
      planned
      tasks {
        collection {
          id
          taskType
          status
          region
          wishDate
          executionDate
          company {
            name
          }
        }
      }
    }
  }
`;

export const PLAN_SET_MUTATION = gql`
  mutation planTaskSet($id: ID!, $planned: String!) {
    updateTaskSet(input: { id: $id, planned: $planned }) {
      taskSet {
        id
      }
    }
  }
`;

export const ASSIGN_TASK_SET = gql`
  mutation assignTaskSet($id: ID!, $assignee: String!) {
    updateTaskSet(input: { id: $id, assignee: $assignee }) {
      taskSet {
        id
      }
    }
  }
`;

export const UPDATE_TASK_SET = gql`
  mutation updateTaskSet($id: ID!, $assignee: String, $planned: String) {
    updateTaskSet(input: { id: $id, assignee: $assignee, planned: $planned }) {
      taskSet {
        id
      }
    }
  }
`;

export const MOVE_TASK = gql`
  mutation moveTask($id: ID!, $taskId: Int!, $taskSetId: Int) {
    moveTask(input: { id: $id, taskId: $taskId, taskSetId: $taskSetId }) {
      task {
        id
      }
    }
  }
`;

export const TASK_SETS_BY_TASK_MATCHING_CRITERIA = gql`
  query getTaskSetsByTaskMatchingCriteria(
    $itemsPerPage: Int!
    $taskSetsWithTaskMatchingCriteria: Int
    $excludeTaskSetOfTask: Int
    $id: Int
  ) {
    taskSets(
      itemsPerPage: $itemsPerPage
      taskSetsWithTaskMatchingCriteria: $taskSetsWithTaskMatchingCriteria
      excludeTaskSetOfTask: $excludeTaskSetOfTask
      id: $id
    ) {
      collection {
        id
        status
        assignee {
          name
        }
        planned
      }
      paginationInfo {
        itemsPerPage
        lastPage
        totalCount
      }
    }
  }
`;
