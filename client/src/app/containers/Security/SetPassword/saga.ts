import { call, put, takeLatest } from 'redux-saga/effects';
import request from 'utils/request';
import { setPasswordActions } from './slice';

export function* submitResetPassword(action) {
  try {
    const options = {
      method: 'POST',
      body: JSON.stringify(action.payload),
    };

    yield put(setPasswordActions.setFormSubmitting(true));
    const response = yield call(request, '/users/set-password' as any, options as any);
    if (response.success) {
      yield put(setPasswordActions.setError(false));
    } else {
      yield put(setPasswordActions.setError(true));
    }
  } catch (err) {
    yield put(setPasswordActions.setError(true));
  }

  yield put(setPasswordActions.setFormSubmitting(false));
}

export function* setPasswordSaga() {
  yield takeLatest(setPasswordActions.setPasswordAction.type, submitResetPassword);
}
