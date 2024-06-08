import React, { Suspense, useEffect } from 'react';
import { CContainer, CSpinner } from '@coreui/react';
import { NestedRoutes, privateRoutes } from '../../../routes';
import { Navigate, Route, Routes } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import { selectFocus, selectSessionStartTime } from '../../App/selectors';
import { TIME_SESSION_LOGOUT } from '../../../../utils/constants';
import { appActions } from '../../App/slice';
import notificationBuilder from '../../../../utils/notificationBuilder';
import { useTranslation } from 'react-i18next';
import moment from 'moment';
import ProtectedRoute from '../../../components/ProtectedRoute';

export default function Content() {
  const dispatch = useDispatch();
  const sessionStartTime = useSelector(selectSessionStartTime);
  const { t } = useTranslation();
  let focus = useSelector(selectFocus);

  useEffect(() => {
    const difference = Number(moment(moment.now()).diff(moment(sessionStartTime), 'seconds'));
    if (difference > TIME_SESSION_LOGOUT) {
      dispatch(appActions.addNotification(notificationBuilder('danger', 'Session expired')));
      dispatch(appActions.clearUserData());
    } else {
      dispatch(appActions.setSessionStartTime(moment().format().toString()));
    }
    // eslint-disable-next-line
  }, [focus]);

  return (
    <main className="c-main ">
      <CContainer fluid>
        <Suspense fallback={<CSpinner color="primary" />}>
          <NestedRoutes routes={privateRoutes()} privateRoute={true} />
          <Routes>
            <Route
              path="/"
              element={
                <ProtectedRoute>
                  <Navigate to="/dashboard" replace />
                </ProtectedRoute>
              }
            />
          </Routes>
        </Suspense>
      </CContainer>
    </main>
  );
}
