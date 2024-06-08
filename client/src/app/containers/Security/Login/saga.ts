import { call, put, takeLatest } from 'redux-saga/effects';
import { loginActions } from './slice';
import { appActions } from '../../App/slice';

import request from '../../../../utils/request';

export function* submitLogin(action) {
  try {
    const options = {
      method: 'POST',
      body: JSON.stringify(action.payload.payload),
    };
    yield put(appActions.startFormSubmitting());
    const data = yield call(request, action.payload.url, options as any);

    yield put(appActions.setToken(data.token));
    yield put(appActions.setUser(data.user));
    yield put(appActions.setRefreshToken(data.refresh_token));
  } catch (error) {
    yield put(loginActions.setError(true));
  }
  yield put(appActions.stopFormSubmitting());
}

export function* loginSaga() {
  yield takeLatest(loginActions.loginAction.type, submitLogin);
}
