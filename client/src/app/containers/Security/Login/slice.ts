import { PayloadAction } from '@reduxjs/toolkit';
import { createSlice } from 'utils/@reduxjs/toolkit';
import { ContainerState } from './types';

// The initial state of the Login container
export const initialState: ContainerState = {
  authenticationError: null,
  refreshError: false,
};

const loginSlice = createSlice({
  name: 'login',
  initialState,
  reducers: {
    loginAction(state, action: PayloadAction<object>) {},
    setError(state, action: PayloadAction<boolean | null>) {
      state.authenticationError = action.payload;
    },
    setRefreshError(state, action: PayloadAction<boolean>) {
      state.refreshError = action.payload;
    },
    clearError(state, action: PayloadAction) {
      state.authenticationError = null;
      state.refreshError = false;
    },
  },
});

export const { actions: loginActions, reducer, name: sliceKey } = loginSlice;
