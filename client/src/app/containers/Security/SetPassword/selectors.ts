import { createSelector } from '@reduxjs/toolkit';
import { RootState } from 'types';
import { initialState } from './slice';

const selectDomain = (state: RootState) => state.setPassword || initialState;

export const selectIsFormSubmitting = createSelector(
  [selectDomain],
  resetPasswordState => resetPasswordState.isFormSubmitting,
);

export const selectError = createSelector([selectDomain], resetPasswordState => resetPasswordState.error);

export const selectErrorMessage = createSelector([selectDomain], resetPasswordState => resetPasswordState.errorMessage);
