import { configureStore, Middleware } from '@reduxjs/toolkit';
import { createInjectorsEnhancer } from 'redux-injectors';
import createSagaMiddleware from 'redux-saga';
import logger from 'redux-logger';

import { createReducer } from './reducers';

export function configureAppStore() {
  const reduxSagaMonitorOptions = {};
  const sagaMiddleware = createSagaMiddleware(reduxSagaMonitorOptions);
  const { run: runSaga } = sagaMiddleware;

  // Create the store with saga middleware
  const middlewares: Middleware[] = [sagaMiddleware];
  if (process.env.NODE_ENV !== 'production') {
    middlewares.push(logger);
  }

  const enhancers = [
    createInjectorsEnhancer({
      createReducer,
      runSaga,
    }),
  ];

  return configureStore({
    reducer: createReducer(),
    preloadedState: {},
    middleware: [...middlewares],
    devTools: process.env.NODE_ENV !== 'production',
    enhancers,
  });
}
