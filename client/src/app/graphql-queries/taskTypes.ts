import { gql } from '@apollo/client';

export const TASK_TYPES_OVERVIEW_QUERY = gql`
  query getTaskTypes(
    $itemsPerPage: Int!
    $name: String
    $taskTypesWithMatchingCriteria: Boolean
    $taskTypesWithMatchingCriteriaForUser: Int
  ) {
    taskTypes(
      itemsPerPage: $itemsPerPage
      name: $name
      taskTypesWithMatchingCriteria: $taskTypesWithMatchingCriteria
      taskTypesWithMatchingCriteriaForUser: $taskTypesWithMatchingCriteriaForUser
    ) {
      collection {
        id
        name
      }
      paginationInfo {
        itemsPerPage
        lastPage
        totalCount
      }
    }
  }
`;
