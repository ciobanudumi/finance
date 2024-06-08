/*eslint-disable import/no-anonymous-default-export, no-template-curly-in-string */
export default {
  REACT_APP_API_BASE_URL: '${REACT_APP_API_BASE_URL}'.includes('REACT_APP_API_BASE_URL')
    ? process.env.REACT_APP_API_BASE_URL
    : '${REACT_APP_API_BASE_URL}',

  REACT_APP_GRAPHQL_API_BASE_URL: '${REACT_APP_GRAPHQL_API_BASE_URL}'.includes('REACT_APP_GRAPHQL_API_BASE_URL')
    ? process.env.REACT_APP_GRAPHQL_API_BASE_URL
    : '${REACT_APP_GRAPHQL_API_BASE_URL}',
};
