import { PayloadAction } from '@reduxjs/toolkit';
import { createSlice } from 'utils/@reduxjs/toolkit';
import { ContainerState } from './types';
import { UsersDataResponse, UserSearch } from '../../../types/User';

// The initial state of the UserSelect container
export const initialState: ContainerState = {
  users: null,
};

const userSelectSlice = createSlice({
  name: 'userSelect',
  initialState,
  reducers: {
    getUsers(state, action: PayloadAction<UserSearch>) {},
    setUsersData(state, action: PayloadAction<UsersDataResponse>) {
      state.users = action.payload.data.users.collection;
    },
  },
});

export const { actions: userSelectActions, reducer, name: sliceKey } = userSelectSlice;
