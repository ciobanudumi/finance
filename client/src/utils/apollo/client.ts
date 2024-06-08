import { ApolloClient, createHttpLink, InMemoryCache, ApolloLink, Operation, NextLink } from '@apollo/client';
import { setContext } from '@apollo/client/link/context';
import { appActions } from '../../app/containers/App/slice';
import config from 'config';
import { store, dispatch } from '../../store/store';
import i18next from 'i18next';

const httpLink = createHttpLink({
  uri: config.REACT_APP_GRAPHQL_API_BASE_URL,
});

const authLink = setContext((_, { headers }) => {
  const token = store.getState().app.token;

  return {
    headers: {
      ...headers,
      'Accept-Language': i18next.language,
      authorization: token ? `Bearer ${token}` : '',
    },
  };
});

const middleLink = new ApolloLink((operation: Operation, forward?: NextLink): any => {
  dispatch(appActions.startLoading());

  return (
    forward &&
    forward(operation).map(response => {
      dispatch(appActions.stopLoading());

      return response;
    })
  );
});

export const client = new ApolloClient({
  link: authLink.concat(middleLink).concat(httpLink),
  cache: new InMemoryCache(),
  defaultOptions: {
    watchQuery: {
      fetchPolicy: 'cache-and-network',
      errorPolicy: 'all',
    },
    query: {
      fetchPolicy: 'no-cache',
      errorPolicy: 'all',
    },
    mutate: {
      errorPolicy: 'all',
    },
  },
});
