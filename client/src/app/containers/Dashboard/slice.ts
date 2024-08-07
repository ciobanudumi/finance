import { PayloadAction, createSlice } from '@reduxjs/toolkit';
import { ContainerState, Period, Transaction, TransactionsResponse } from './types';

// The initial state of the Tasks container
export const initialState: ContainerState = {
  selectedCustomer: false,
  transactions: [],
  totalTransactionsCount: null,
  period: { startDate: '2024-07-01', endDate: '2024-07-31' },
};

const dashboardSlice = createSlice({
  name: 'dashboard',
  initialState,
  reducers: {
    setPeriod(state, action: PayloadAction<Period>) {
      state.period = action.payload;
    },
    getTransactions() {},
    setTransactions(state, action: PayloadAction<TransactionsResponse>) {
      let data = [] as Transaction[];
      for (let i = 0; i < action.payload.data.transactions.totalCount; ++i) {
        data.push(action.payload.data.transactions.edges[i].node);
      }
      state.transactions = data;
      state.totalTransactionsCount = action.payload.data.transactions.totalCount;
    },
    setSelectedUser(state, action: PayloadAction<boolean>) {
      state.selectedCustomer = action.payload;
    },
  },
});

export const { actions: dashboardActions, reducer, name: sliceKey } = dashboardSlice;
