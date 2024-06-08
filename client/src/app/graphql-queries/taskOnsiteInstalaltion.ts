import { gql } from '@apollo/client';

export const CREATE_TASK_ONSITE_INSTALLATION = gql`
  mutation CreateTaskOnsiteInstallation(
    $taskSet: String
    $company: String!
    $onBehalfOf: String!
    $region: Int!
    $preferredExecutor: String
    $migration: Boolean!
    $wishDate: String
    $executionDate: String
    $portType: String
    $contactPerson: String!
  ) {
    createTaskOnsiteInstallation(
      input: {
        taskSet: $taskSet
        company: $company
        onBehalfOf: $onBehalfOf
        region: $region
        preferredExecutor: $preferredExecutor
        migration: $migration
        wishDate: $wishDate
        executionDate: $executionDate
        portType: $portType
        contactPerson: $contactPerson
      }
    ) {
      taskOnsiteInstallation {
        id
      }
    }
  }
`;

export const TASK_ONSITE_INSTALLATION_DETAILS_QUERY = gql`
  query getTaskOnsiteInstallation($id: ID!) {
    taskOnsiteInstallation(id: $id) {
      id
      status
      taskType
      company {
        id
        name
        fiberCrewId
      }
      onBehalfOf
      region
      preferredExecutor {
        id
        name
      }
      migration
      wishDate
      executionDate
      finished
      createdAt
      taskSet {
        id
        status
        assignee {
          name
        }
      }
      portType
      contactPerson {
        id
        name
        street
        zipcode
        houseNumber
        houseNumberExtension
        roomNumber
        city
        phoneNumber
        mobileNumber
        emailAddress
        notes
      }
    }
  }
`;

export const EDIT_TASK_ONSITE_INSTALLATION = gql`
  mutation EditTaskOnsiteInstallation(
    $id: ID!
    $taskId: Int!
    $company: String
    $onBehalfOf: String
    $region: Int
    $preferredExecutor: String
    $migration: Boolean
    $wishDate: String
    $executionDate: String
    $portType: String
    $contactPerson: String
  ) {
    updateTaskOnsiteInstallation(
      input: {
        id: $id
        taskId: $taskId
        company: $company
        onBehalfOf: $onBehalfOf
        region: $region
        preferredExecutor: $preferredExecutor
        migration: $migration
        wishDate: $wishDate
        executionDate: $executionDate
        portType: $portType
        contactPerson: $contactPerson
      }
    ) {
      taskOnsiteInstallation {
        id
      }
    }
  }
`;
