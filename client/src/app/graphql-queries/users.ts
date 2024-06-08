import { gql } from '@apollo/client';

export const USERS_OVERVIEW_QUERY = filterSortFieldPlaceholder => gql`
  query GetUsers($page: Int!, $itemsPerPage: Int!, $order: String!, $usersWithMatchingCriteria: Boolean, $name: String) {
    users(
        page: $page, 
        itemsPerPage: $itemsPerPage, 
        order:{${filterSortFieldPlaceholder}: $order}, 
        usersWithMatchingCriteria: $usersWithMatchingCriteria, 
        name: $name
    ) {
      collection {
        id
        name
        username
        email
        roles
      }
      paginationInfo {
        itemsPerPage
        lastPage
        totalCount
      }
    }
  }
`;

export const CREATE_USER = gql`
  mutation createUser($name: String!, $roles: Iterable!, $email: String!, $companies: Iterable!) {
    createUser(input: { name: $name, roles: $roles, email: $email, companies: $companies }) {
      user {
        id
      }
    }
  }
`;

export const USER_QUERY = gql`
  query getUser($id: ID!) {
    user(id: $id) {
      id
      name
      email
      roles
      companies {
        collection {
          id
          name
        }
      }
    }
  }
`;

export const EDIT_USER = gql`
  mutation updateUser($id: ID!, $name: String!, $roles: Iterable!, $email: String!, $companies: [String]) {
    updateUser(input: { id: $id, name: $name, roles: $roles, email: $email, companies: $companies }) {
      user {
        id
      }
    }
  }
`;

export const DELETE_USER = gql`
  mutation deleteUser($id: ID!) {
    deleteUser(input: { id: $id }) {
      user {
        id
      }
    }
  }
`;

export const USERS_QUERY_BY_MATCHING_CRITERIA = gql`
  query GetUsers($itemsPerPage: Int!, $createTaskMatchingCriteria: String!, $name: String) {
    users(itemsPerPage: $itemsPerPage, createTaskMatchingCriteria: $createTaskMatchingCriteria, name: $name) {
      collection {
        id
        name
        username
        email
      }
      paginationInfo {
        itemsPerPage
        lastPage
        totalCount
      }
    }
  }
`;

export const USERS_QUERY_BY_ASSIGNEE_TASK_SET_MATCHING_CRITERIA = gql`
  query GetUsersByAssigneeTaskSetMatchingCriteria(
    $itemsPerPage: Int!
    $assigneeTaskSetMatchingCriteria: Int
    $name: String
  ) {
    users(itemsPerPage: $itemsPerPage, assigneeTaskSetMatchingCriteria: $assigneeTaskSetMatchingCriteria, name: $name) {
      collection {
        id
        name
        username
        email
      }
      paginationInfo {
        itemsPerPage
        lastPage
        totalCount
      }
    }
  }
`;
