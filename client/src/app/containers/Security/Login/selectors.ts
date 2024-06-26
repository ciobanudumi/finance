import { createSelector } from '@reduxjs/toolkit';

import { RootState } from 'types';
import { initialState } from './slice';

const selectDomain = (state: RootState) => state.login || initialState;

export const selectLogin = createSelector([selectDomain], loginState => loginState);
export const selectLoginError = createSelector([selectDomain], loginState => loginState.authenticationError);
export const selectRefreshError = createSelector([selectDomain], loginState => loginState.refreshError);
