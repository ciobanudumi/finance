import { PayloadAction } from '@reduxjs/toolkit';
import { createSlice } from 'utils/@reduxjs/toolkit';
import { SetPasswordState } from './types';

export const initialState = {
  isFormSubmitting: false,
  token: null,
  error: null,
  errorMessage: null,
} as SetPasswordState;

const setPasswordSlice = createSlice({
  name: 'setPassword',
  initialState,
  reducers: {
    setPasswordAction(state, action: PayloadAction<object>) {},
    setFormSubmitting(state, action: PayloadAction<boolean>) {
      state.isFormSubmitting = action.payload;
    },
    setToken(state, action: PayloadAction<string | null>) {
      state.token = action.payload;
    },
    setError(state, action: PayloadAction<boolean | null>) {
      state.error = action.payload;
    },
    setErrorMessage(state, action: PayloadAction<string | null>) {
      state.errorMessage = action.payload;
    },
    removeData() {
      return initialState;
    },
  },
});

export const { actions: setPasswordActions, reducer, name: sliceKey } = setPasswordSlice;
