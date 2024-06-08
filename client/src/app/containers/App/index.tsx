import * as React from 'react';
import '../../../styles/scss/style.scss';
import { useInjectReducer } from 'redux-injectors';
import { appActions, reducer, sliceKey } from './slice';
import { useDispatch, useSelector } from 'react-redux';
import { NestedRoutes, publicRoutes } from '../../routes';
import { BrowserRouter } from 'react-router-dom';
import { selectNotifications } from './selectors';
import { Notification } from '../../components/Notification/Loadable';

export default function App() {
  useInjectReducer({ key: sliceKey, reducer: reducer });
  const notifications = useSelector(selectNotifications);
  const dispatch = useDispatch();
  window.onfocus = function onFocus() {
    dispatch(appActions.changeFocus(true));
  };
  window.onblur = function onBlur() {
    dispatch(appActions.changeFocus(false));
  };

  return (
    <BrowserRouter>
      <NestedRoutes routes={publicRoutes} />
      <React.Suspense fallback={null}>
        <Notification notifications={notifications} />
      </React.Suspense>
    </BrowserRouter>
  );
}
