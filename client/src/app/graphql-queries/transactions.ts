import { gql } from '@apollo/client';

export const TRANSACTIONS_OVERVIEW_QUERY = gql`
  query getTransactions($before: String!, $after: String!) {
    transactions(date: [{ before: $before, after: $after }], order: { date: "DESC" }) {
      edges {
        node {
          id
          type
          amount
          recursive
          description
          category {
            name
          }
          date
        }
      }
      totalCount
    }
  }
`;

export const DELETE_TRANSACTIONS_QUERY = gql`
  mutation deleteTransactions($id: ID!) {
    deleteTransactions(input: { id: $id }) {
      transactions {
        id
      }
    }
  }
`;
