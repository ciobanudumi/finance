import { gql } from '@apollo/client';

export const CREATE_TASK_PATCH_REMOVE = gql`
  mutation CreateTaskPatchRemove(
    $company: String!
    $onBehalfOf: String
    $region: Int!
    $preferredExecutor: String
    $migration: Boolean!
    $wishDate: String
    $executionDate: String
    $registrationDate: String
    $taskSet: String
    $portType: String
    $rfTasksetId: Int!
    $pop: String!
    $row: Int!
    $frame: Int!
    $block: String!
    $trayFiber: String!
    $positionFiber: Int!
    $portingId: Int!
    $equipment: String!
    $activePort: String!
    $positionEquipment: String!
    $contactPerson: String!
  ) {
    createTaskPatchRemove(
      input: {
        company: $company
        onBehalfOf: $onBehalfOf
        region: $region
        preferredExecutor: $preferredExecutor
        migration: $migration
        wishDate: $wishDate
        executionDate: $executionDate
        registrationDate: $registrationDate
        taskSet: $taskSet
        portType: $portType
        rfTasksetId: $rfTasksetId
        pop: $pop
        row: $row
        frame: $frame
        block: $block
        trayFiber: $trayFiber
        positionFiber: $positionFiber
        portingId: $portingId
        equipment: $equipment
        activePort: $activePort
        positionEquipment: $positionEquipment
        contactPerson: $contactPerson
      }
    ) {
      taskPatchRemove {
        id
      }
    }
  }
`;

export const TASK_PATCH_REMOVE_DETAILS_QUERY = gql`
  query getTaskPatchRemove($id: ID!) {
    taskPatchRemove(id: $id) {
      id
      status
      holdCode {
        id
        type
        code
        description
      }
      holdReason
      holdExpectedResumeDate
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
      registrationDate
      rfTasksetId
      pop
      row
      frame
      block
      trayFiber
      positionFiber
      portingId
      equipment
      activePort
      positionEquipment
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

export const EDIT_TASK_PATCH_REMOVE = gql`
  mutation EditTaskPatchRemove(
    $id: ID!
    $taskId: Int!
    $company: String
    $onBehalfOf: String
    $region: Int
    $preferredExecutor: String
    $migration: Boolean
    $wishDate: String
    $executionDate: String
    $registrationDate: String
    $portType: String
    $rfTasksetId: Int
    $pop: String
    $row: Int
    $frame: Int
    $block: String
    $trayFiber: String
    $positionFiber: Int
    $portingId: Int
    $equipment: String
    $activePort: String
    $positionEquipment: String
    $contactPerson: String
  ) {
    updateTaskPatchRemove(
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
        registrationDate: $registrationDate
        portType: $portType
        rfTasksetId: $rfTasksetId
        pop: $pop
        row: $row
        frame: $frame
        block: $block
        trayFiber: $trayFiber
        positionFiber: $positionFiber
        portingId: $portingId
        equipment: $equipment
        activePort: $activePort
        positionEquipment: $positionEquipment
        contactPerson: $contactPerson
      }
    ) {
      taskPatchRemove {
        id
      }
    }
  }
`;
