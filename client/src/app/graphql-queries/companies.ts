import { gql } from '@apollo/client';

export const COMPANIES_OVERVIEW_QUERY = filterSortFieldPlaceholder => gql`
  query GetCompanies(
    $page: Int!, 
    $itemsPerPage: Int!, 
    $order: String!, 
    $companiesWithMatchingCriteria: Boolean, 
    $companiesWithTasks: Boolean, 
    $name: String
) {
    companies(
        page: $page, 
        itemsPerPage: $itemsPerPage, 
        order:{${filterSortFieldPlaceholder}: $order},
        companiesWithMatchingCriteria: $companiesWithMatchingCriteria
        companiesWithTasks: $companiesWithTasks
        name: $name
    ) {
      collection {
        id
        name
        administrativeDisabled
        fiberCrewId
      }
      paginationInfo {
        itemsPerPage
        lastPage
        totalCount
      }
    }
  }
`;

export const COMPANIES_QUERY_BY_NAME = gql`
  query GetCompanies($itemsPerPage: Int!, $name: String, $administrativeDisabled: Boolean!) {
    companies(itemsPerPage: $itemsPerPage, name: $name, administrativeDisabled: $administrativeDisabled) {
      collection {
        id
        name
      }
    }
  }
`;

export const COMPANIES_QUERY_BY_MATCHING_CRITERIA = gql`
  query GetCompaniesByMatchingCriteria(
    $name: String
    $itemsPerPage: Int
    $administrativeDisable: Boolean
    $companiesWithMatchingCriteriaForUser: Int
    $companiesWithMatchingCriteriaOfTaskType: String
    $companiesWithMatchingCriteria: Boolean
  ) {
    companies(
      name: $name
      itemsPerPage: $itemsPerPage
      administrativeDisabled: $administrativeDisable
      companiesWithMatchingCriteriaForUser: $companiesWithMatchingCriteriaForUser
      companiesWithMatchingCriteriaOfTaskType: $companiesWithMatchingCriteriaOfTaskType
      companiesWithMatchingCriteria: $companiesWithMatchingCriteria
    ) {
      collection {
        id
        name
      }
    }
  }
`;

export const COMPANY_QUERY = gql`
  query getCompany($id: ID!) {
    company(id: $id) {
      id
      name
      administrativeDisabled
      fiberCrewId
    }
  }
`;

export const CREATE_COMPANY = gql`
  mutation createCompany($name: String!, $administrativeDisabled: Boolean!, $fiberCrewId: Int) {
    createCompany(input: { name: $name, administrativeDisabled: $administrativeDisabled, fiberCrewId: $fiberCrewId }) {
      company {
        id
      }
    }
  }
`;

export const EDIT_COMPANY = gql`
  mutation updateCompany($id: ID!, $name: String!, $administrativeDisabled: Boolean!, $fiberCrewId: Int) {
    updateCompany(
      input: { id: $id, name: $name, administrativeDisabled: $administrativeDisabled, fiberCrewId: $fiberCrewId }
    ) {
      company {
        id
      }
    }
  }
`;

export const DELETE_COMPANY = gql`
  mutation deleteCompany($id: ID!) {
    deleteCompany(input: { id: $id }) {
      company {
        id
      }
    }
  }
`;
