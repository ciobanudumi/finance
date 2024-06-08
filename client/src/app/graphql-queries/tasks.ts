import { gql } from '@apollo/client';

export const TASKS_OVERVIEW_QUERY = filterSortFieldPlaceholder => gql`
  query GetTasks($page: Int!, $itemsPerPage: Int!, $order: String!) {
    tasks(page: $page, itemsPerPage: $itemsPerPage, order:{${filterSortFieldPlaceholder}: $order}) {
      collection {
        id
        taskType
        finished
        company {
          name
        }
        preferredExecutor {
          name
        }
        onBehalfOf
        wishDate
        createdAt
        executionDate
        finished
        taskSet {
          id
        }
        region
      }
      paginationInfo {
        itemsPerPage
        lastPage
        totalCount
      }
    }
  }
`;

export const CHANGE_STATUS_TASK_MUTATION = gql`
  mutation changeStatusTask(
    $id: ID!
    $taskId: Int!
    $status: String!
    $holdCode: Int
    $holdReason: String
    $holdExpectedResumeDate: String
  ) {
    changeStatusTask(
      input: {
        id: $id
        taskId: $taskId
        status: $status
        holdCode: $holdCode
        holdReason: $holdReason
        holdExpectedResumeDate: $holdExpectedResumeDate
      }
    ) {
      task {
        id
        status
      }
    }
  }
`;

export const GET_DISTINCT_REGIONS_FROM_TASK = gql`
  query GetTasks($page: Int!, $itemsPerPage: Int!, $order: String!, $uniqueTaskRegion: Boolean, $region: Int) {
    tasks(
      page: $page
      itemsPerPage: $itemsPerPage
      order: { region: $order }
      uniqueTaskRegion: $uniqueTaskRegion
      region: $region
    ) {
      collection {
        region
      }
      paginationInfo {
        itemsPerPage
        lastPage
        totalCount
      }
    }
  }
`;

export const EDIT_TASK_DUMMY = gql`
  mutation EditTask(
    $id: ID!
    $taskSet: String
    $company: String!
    $onBehalfOf: String!
    $region: Int!
    $preferredExecutor: String
    $migration: Boolean!
    $wishDate: String
    $executionDate: String
    $portType: String
  ) {
    updateTask(
      input: {
        id: $id
        taskSet: $taskSet
        company: $company
        onBehalfOf: $onBehalfOf
        region: $region
        preferredExecutor: $preferredExecutor
        migration: $migration
        wishDate: $wishDate
        executionDate: $executionDate
        portType: $portType
      }
    ) {
      task {
        id
      }
    }
  }
`;
