import { call, put, takeLatest } from 'redux-saga/effects';
import { companySelectActions } from './slice';
import queryRequest from '../../../utils/apollo/queryRequest';
import { COMPANIES_QUERY_BY_NAME } from '../../graphql-queries/companies';
import { DEFAULT_ITEMS_PER_PAGE } from '../../../utils/constants';

export function* getCompaniesData(action) {
  try {
    const data = yield call(queryRequest, COMPANIES_QUERY_BY_NAME as any, {
      name: action.payload.name,
      itemsPerPage: action.payload.itemsPerPage || DEFAULT_ITEMS_PER_PAGE,
      administrativeDisabled: action.payload.administrativeDisabled || false,
    });
    yield put(companySelectActions.setCompaniesData(data));
  } catch (error: any) {
    console.log(error['message']);
  }
}

export function* companySelectSaga() {
  yield takeLatest(companySelectActions.getCompanies.type, getCompaniesData);
}
