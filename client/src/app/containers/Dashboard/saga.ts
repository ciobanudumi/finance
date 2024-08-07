import { call, put, select, takeLatest } from 'redux-saga/effects';
import { dashboardActions } from './slice';
import queryRequest from '../../../utils/apollo/queryRequest';
import { TRANSACTIONS_OVERVIEW_QUERY } from '../../graphql-queries/transactions';
import * as selectors from './selectors';

export function* getData() {
  try {
    const period = yield select(selectors.selectPeriod);
    const data = yield call(queryRequest, TRANSACTIONS_OVERVIEW_QUERY as any, {
      before: period.endDate,
      after: period.startDate,
    });
    yield put(dashboardActions.setTransactions(data));
  } catch (error: any) {
    console.log(error['message']);
  }
}

export function* dashboardSaga() {
  yield takeLatest(dashboardActions.getTransactions.type, getData);
}
