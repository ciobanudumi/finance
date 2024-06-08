import { createSelector } from '@reduxjs/toolkit';
import { RootState } from 'types';
import { initialState } from './slice';

const selectDomain = (state: RootState) => state.userSelect || initialState;

export const selectUsersData = createSelector([selectDomain], userSelectState => userSelectState.users);
