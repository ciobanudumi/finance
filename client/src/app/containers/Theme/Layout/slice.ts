import { PayloadAction, createSlice } from '@reduxjs/toolkit';
import { ContainerState } from './types';

// The initial state of the Layout container
export const initialState: ContainerState = {
  sidebarShow: true,
  sidebarUnfoldable: false,
};

const layoutSlice = createSlice({
  name: 'layout',
  initialState,
  reducers: {
    heartBeat() {},
    setSidebarShow(state, action: PayloadAction<boolean>) {
      state.sidebarShow = action.payload;
    },
    setSidebarUnfoldable(state, action: PayloadAction<boolean>) {
      state.sidebarUnfoldable = action.payload;
    },
  },
});

export const { actions: layoutActions, reducer, name: sliceKey } = layoutSlice;
