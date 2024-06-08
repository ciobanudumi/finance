import { PayloadAction, createSlice } from '@reduxjs/toolkit';
import { ContainerState } from './types';

// The initial state of the Tasks container
export const initialState: ContainerState = { selectedCustomer: false };

const dashboardSlice = createSlice({
  name: 'dashboard',
  initialState,
  reducers: {
    setSelectedUser(state, action: PayloadAction<boolean>) {
      state.selectedCustomer = action.payload;
    },
  },
});

export const { actions: dashboardActions, reducer, name: sliceKey } = dashboardSlice;
