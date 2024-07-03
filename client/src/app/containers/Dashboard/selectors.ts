import { createSelector } from '@reduxjs/toolkit';

import { RootState } from 'types';
import { initialState } from './slice';

const selectDomain = (state: RootState) => state.dashboard || initialState;

export const selectTransactions = createSelector([selectDomain], dashboardState => {
  return dashboardState.transactions;
});
export const selectTotalTransactionsCount = createSelector([selectDomain], dashboardState => {
  return dashboardState.totalTransactionsCount;
});
export const selectPeriod = createSelector([selectDomain], dashboardState => {
  return dashboardState.period;
});
