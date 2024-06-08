// The initial state of the App container

import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import { ContainerState, User, Notification } from './types';
import { localStorageGet, localStorageRemove, localStorageSet } from '../../../utils/localStorage';

export const initialState: ContainerState = {
  user: localStorageGet('user') ? JSON.parse(localStorageGet('user') as string) : null,
  token: localStorageGet('token') ? JSON.parse(localStorageGet('token') as string) : null,
  loading: false,
  notifications: null,
  focus: true,
  sessionStartTime: localStorageGet('sessionStartTime') ?? null,
  isFormSubmitting: false,
  refresh_token: localStorageGet('refresh_token') ? JSON.parse(localStorageGet('refresh_token') as string) : null,
};

const appSlice = createSlice({
  name: 'app',
  initialState,
  reducers: {
    setToken(state, action: PayloadAction<string>) {
      state.token = action.payload;
      localStorageSet('token', JSON.stringify(action.payload));
    },
    setUser(state, action: PayloadAction<User | null>) {
      state.user = action.payload;
      localStorageSet('user', JSON.stringify(action.payload));
    },
    setRefreshToken(state, action: PayloadAction<string | null>) {
      state.refresh_token = action.payload;
      localStorageSet('refresh_token', JSON.stringify(action.payload));
    },
    setSessionStartTime(state, action: PayloadAction<string | null>) {
      state.sessionStartTime = action.payload;
      localStorageSet('sessionStartTime', action.payload);
    },
    clearUserData(state) {
      state.user = null;
      state.token = null;
      state.refresh_token = null;
      state.sessionStartTime = null;
      localStorageRemove('user');
      localStorageRemove('token');
      localStorageRemove('refresh_token');
      localStorageRemove('sessionStartTime');
    },
    removeNotifications(state: ContainerState, action: PayloadAction<string | undefined>) {
      const data: Notification[] = [];
      if (!action.payload) {
        state.notifications = null;
        return;
      }
      if (state.notifications) {
        state.notifications.forEach(element => {
          if (element.id !== action.payload) {
            data.push(element);
          }
        });
      }
      state.notifications = data;
    },
    addNotifications(state: ContainerState, action: PayloadAction<Notification[]>) {
      let data: Notification[] = [];
      if (state.notifications) {
        data = Array.from(state.notifications);
      }
      data.push(...action.payload);
      state.notifications = data;
    },
    addNotification(state, action: PayloadAction<Notification>) {
      const data: Array<Notification> = [];
      if (state.notifications) {
        state.notifications.forEach(element => data.push(element));
      }
      data.push(action.payload);
      state.notifications = data;
    },
    getData() {},
    startLoading(state) {
      state.loading = true;
    },
    stopLoading(state) {
      state.loading = false;
    },
    changeFocus(state, action: PayloadAction<boolean>) {
      state.focus = action.payload;
    },
    startFormSubmitting(state) {
      state.isFormSubmitting = true;
    },
    stopFormSubmitting(state) {
      state.isFormSubmitting = false;
    },
  },
});

export const { actions: appActions, reducer, name: sliceKey } = appSlice;
