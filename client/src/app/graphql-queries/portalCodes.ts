import { gql } from '@apollo/client';
export const PORTAL_CODES_COLLECTION_QUERY = gql`
  query GetPortalCodes(
    $page: Int!
    $itemsPerPage: Int!
    $order: String!
    $type: String
    $taskTypeId: Int
    $taskTypeName: String
  ) {
    portalCodes(
      page: $page
      itemsPerPage: $itemsPerPage
      order: { id: $order }
      type: $type
      taskTypes_id: $taskTypeId
      taskTypes_name: $taskTypeName
    ) {
      collection {
        id
        type
        code
        description
      }
      paginationInfo {
        itemsPerPage
        lastPage
        totalCount
        __typename
      }
      __typename
    }
  }
`;
