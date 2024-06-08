import { call, put, select, takeLatest } from 'redux-saga/effects';
import { layoutActions } from './slice';
import { appActions } from '../../App/slice';
import * as appSelectors from '../../App/selectors';
import request from '../../../../utils/request';
import { loginActions } from '../../Security/Login/slice';

export function* refreshToken() {
  try {
    const options = {
      method: 'POST',
      body: JSON.stringify({ refresh_token: yield select(appSelectors.selectRefreshToken) }),
    };
    const data = yield call(request, '/token/refresh' as any, options as any);
    yield put(appActions.setToken(data.token));
    yield put(appActions.setRefreshToken(data.refresh_token));
  } catch (error: any) {
    yield put(loginActions.setRefreshError(true));
    yield put(appActions.clearUserData());
    console.log(error['message']);
  }
}

export function* layoutSaga() {
  yield takeLatest(layoutActions.heartBeat.type, refreshToken);
}
