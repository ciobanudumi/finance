import { client } from './client';

function checkStatus(response) {
  if (response.errors) {
    response.errors.map(error => {
      throw new Error(error.message);
    });
  }

  return response;
}

export default function queryRequest(query, variables) {
  return client.query({ query: query, variables: variables }).then(checkStatus);
}
