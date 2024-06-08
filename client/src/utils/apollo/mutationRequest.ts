import { client } from './client';

function checkStatus(response) {
  if (response.errors) {
    response.errors.map(error => {
      throw new Error(error.message);
    });
  }

  return response;
}

export default function mutationRequest(query, variables) {
  return client.mutate({ mutation: query, variables: variables }).then(checkStatus);
}
