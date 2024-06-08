import { createSelector } from '@reduxjs/toolkit';

import { RootState } from 'types';
import { initialState } from './slice';

const selectDomain = (state: RootState) => state.layout || initialState;

export const selectSidebarShow = createSelector([selectDomain], layoutState => layoutState.sidebarShow);

export const selectSidebarUnfoldable = createSelector([selectDomain], layoutState => layoutState.sidebarUnfoldable);
