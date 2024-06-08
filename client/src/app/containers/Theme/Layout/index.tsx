import React, { useEffect } from 'react';

import { useInjectReducer, useInjectSaga } from 'redux-injectors';
import { layoutActions, reducer, sliceKey } from './slice';
import { Sidebar } from '../Sidebar/Loadable';
import { Header } from '../Header/Loadable';
import { Content } from '../Content/Loadable';
import { Footer } from '../Footer/Loadable';
import { layoutSaga } from './saga';
import { useDispatch } from 'react-redux';
import { REFRESH_TOKEN_TIME } from '../../../../utils/constants';

export const Layout = () => {
  useInjectReducer({ key: sliceKey, reducer: reducer });
  useInjectSaga({ key: sliceKey, saga: layoutSaga });
  const dispatch = useDispatch();

  useEffect(() => {
    const interval = setInterval(() => {
      dispatch(layoutActions.heartBeat());
    }, REFRESH_TOKEN_TIME);
    return () => clearInterval(interval);
  }, [dispatch]);

  return (
    <>
      <Sidebar />
      <div className="wrapper d-flex flex-column min-vh-100 bg-light dark:bg-transparent">
        <Header />
        <div className="body flex-grow-1 px-3">
          <Content />
        </div>
        <Footer />
      </div>
    </>
  );
};

export default Layout;
