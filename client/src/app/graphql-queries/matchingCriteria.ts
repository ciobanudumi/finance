import { gql } from '@apollo/client';

export const MATCHING_CRITERIA_OVERVIEW_QUERY = filterSortFieldPlaceholder => gql`
  query GetMatchingCriterias(
    $page: Int!
    $itemsPerPage: Int!
    $order: String
    $regionMatchingCriteria: String
    $taskTypeIdsMatchingCriteria: String
    $userIdsMatchingCriteria: String
    $companyIdsMatchingCriteria: String
  ) {
    matchingCriterias(
      page: $page
      itemsPerPage: $itemsPerPage
      order: { ${filterSortFieldPlaceholder}: $order }
      regionMatchingCriteria: $regionMatchingCriteria
      taskTypeIdsMatchingCriteria: $taskTypeIdsMatchingCriteria
      userIdsMatchingCriteria: $userIdsMatchingCriteria
      companyIdsMatchingCriteria: $companyIdsMatchingCriteria
    ) {
      collection {
        id
        user {
          name
        }
        company {
          name
        }
        maxRegion
        minRegion
        taskType {
          name
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

export const MATCHING_CRITERIA_TASK_CREATE_QUERY = gql`
  query GetMatchingCriteriasTaskCreate(
    $itemsPerPage: Int!
    $regionMatchingCriteria: String
    $taskTypeNamesMatchingCriteria: String
    $userIdsMatchingCriteria: String
    $companyIdsMatchingCriteria: String
  ) {
    matchingCriterias(
      itemsPerPage: $itemsPerPage
      regionMatchingCriteria: $regionMatchingCriteria
      taskTypeNamesMatchingCriteria: $taskTypeNamesMatchingCriteria
      userIdsMatchingCriteria: $userIdsMatchingCriteria
      companyIdsMatchingCriteria: $companyIdsMatchingCriteria
    ) {
      collection {
        id
        user {
          name
        }
        company {
          name
        }
        maxRegion
        minRegion
        taskType {
          name
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

export const CREATE_MULTI_MATCHING_CRITERIA = gql`
  mutation createMultiMatchingCriteria(
    $users: Iterable!
    $companies: Iterable!
    $taskTypes: Iterable!
    $minRegion: Int!
    $maxRegion: Int!
  ) {
    createMultiMatchingCriteria(
      input: {
        users: $users
        companies: $companies
        taskTypes: $taskTypes
        minRegion: $minRegion
        maxRegion: $maxRegion
      }
    ) {
      clientMutationId
    }
  }
`;

export const BULK_DELETE_MATCHING_CRITERIA = gql`
  mutation bulkDeleteMatchingCriteria($ids: Iterable!) {
    bulkDeleteMatchingCriteria(input: { ids: $ids }) {
      clientMutationId
    }
  }
`;
