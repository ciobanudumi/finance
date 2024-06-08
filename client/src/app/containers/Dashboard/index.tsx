import * as React from 'react';
import { useInjectReducer, useInjectSaga } from 'redux-injectors';
import { reducer, sliceKey } from './slice';
import { dashboardSaga } from './saga';
import { useSelector } from 'react-redux';
import { selectUser } from '../App/selectors';
import { Helmet } from 'react-helmet-async';
import { useTranslation } from 'react-i18next';

export default function Dashboard() {
  useInjectReducer({ key: sliceKey, reducer: reducer });
  useInjectSaga({ key: sliceKey, saga: dashboardSaga });
  const { t } = useTranslation();
  const user = useSelector(selectUser);

  return (
    <>
      <Helmet>
        <title>Dashboard</title>
      </Helmet>
      {user && <p>User {user?.name} is logged!</p>}
      {!user && <p>User is no logged</p>}
    </>
  );
}
