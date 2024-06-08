import { createSelector } from '@reduxjs/toolkit';
import { RootState } from 'types';
import { initialState } from './slice';

const selectDomain = (state: RootState) => state.companySelect || initialState;

export const selectCompaniesData = createSelector([selectDomain], companySelectState => companySelectState.companies);
