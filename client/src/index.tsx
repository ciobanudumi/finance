import 'react-app-polyfill/ie11';
import 'react-app-polyfill/stable';

import 'core-js';

import * as React from 'react';
import { Provider } from 'react-redux';
import { store } from './store/store';
import { createRoot } from 'react-dom/client';
import * as serviceWorker from 'serviceWorker';
// Import root app
import { App } from 'app/containers/App/Loadable';
import { client } from './utils/apollo/client';
import { ApolloProvider } from '@apollo/client';
import { HelmetProvider } from 'react-helmet-async';

import './locales/i18n';

const container = document.getElementById('root');
const root = createRoot(container!);

root.render(
  <Provider store={store}>
    <ApolloProvider client={client}>
      <HelmetProvider>
        <React.StrictMode>
          <App />
        </React.StrictMode>
      </HelmetProvider>
    </ApolloProvider>
  </Provider>,
);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
