import { Dashboard } from './containers/Dashboard/Loadable';
import { Route, Routes } from 'react-router';
import React from 'react';
import { AppRoutes } from '../types/AppRoutes';
import { Layout } from './containers/Theme/Layout/Loadable';
import { NotFoundPage } from './components/NotFoundPage/Loadable';
import { Login } from './containers/Security/Login/Loadable';
import ProtectedRoute from './components/ProtectedRoute';
import { SetPassword } from './containers/Security/SetPassword/Loadable';

export const publicRoutes = [
  {
    path: '/login',
    component: Login,
  },
  {
    path: '/set-password',
    component: SetPassword,
  },
  {
    path: '/*',
    component: Layout,
  },
];
export const privateRoutes = (): AppRoutes[] => [
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    routes: null,
  },
  {
    path: '/*',
    name: '',
    component: NotFoundPage,
    routes: null,
  },
];

export function NestedRoutes({ routes, url = '', privateRoute = false }) {
  const renderRoutes = (arrayRoutes, parentUrl) => {
    if (!arrayRoutes) {
      return null;
    }
    parentUrl = parentUrl === '/' ? '' : parentUrl; // ignore "/" root url so we can use "/<path" further down the nested routes
    return arrayRoutes.map(route => {
      const { component: Component, path, routes: subRoutes } = route;

      return (
        <Route
          path={`${parentUrl}${path}`}
          key={`${parentUrl}${path}`}
          element={
            privateRoute ? (
              <ProtectedRoute>
                <Component />
              </ProtectedRoute>
            ) : (
              <Component />
            )
          }
        >
          {subRoutes && renderRoutes(subRoutes, `${parentUrl}${path}`)}
        </Route>
      );
    });
  };
  return <Routes>{renderRoutes(routes, url)}</Routes>;
}

export default NestedRoutes;
