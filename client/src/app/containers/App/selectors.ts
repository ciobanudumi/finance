import { createSelector } from '@reduxjs/toolkit';

import { RootState } from 'types';
import { initialState } from './slice';

const selectDomain = (state: RootState) => state.app || initialState;

export const selectLoading = createSelector([selectDomain], appState => appState.loading);

export const selectSessionStartTime = createSelector([selectDomain], appState => appState.sessionStartTime);

export const selectUser = createSelector([selectDomain], appState => appState.user);

export const selectRefreshToken = createSelector([selectDomain], appState => appState.refresh_token);

export const selectFocus = createSelector([selectDomain], appState => appState.focus);

export const selectIsFormSubmitting = createSelector([selectDomain], appState => appState.isFormSubmitting);

export const selectNotifications = createSelector([selectDomain], appState => appState.notifications);
