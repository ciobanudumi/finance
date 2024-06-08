import { call, put, takeLatest } from 'redux-saga/effects';
import { userSelectActions } from './slice';
import queryRequest from '../../../utils/apollo/queryRequest';
import { USERS_QUERY_BY_ASSIGNEE_TASK_SET_MATCHING_CRITERIA } from '../../graphql-queries/users';
import { DEFAULT_ITEMS_PER_PAGE } from '../../../utils/constants';

export function* getUsersData(action) {
  try {
    const data = yield call(queryRequest, USERS_QUERY_BY_ASSIGNEE_TASK_SET_MATCHING_CRITERIA as any, {
      name: action.payload.name,
      itemsPerPage: action.payload.itemsPerPage || DEFAULT_ITEMS_PER_PAGE,
      assigneeTaskSetMatchingCriteria: action.payload.assigneeTaskSetMatchingCriteria || null,
    });
    yield put(userSelectActions.setUsersData(data));
  } catch (error: any) {
    console.log(error['message']);
  }
}

export function* userSelectSaga() {
  yield takeLatest(userSelectActions.getUsers.type, getUsersData);
}
