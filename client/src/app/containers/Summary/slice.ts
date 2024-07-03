import { PayloadAction, createSlice } from '@reduxjs/toolkit';
import { ContainerState, Period, Transaction, TransactionsResponse } from './types';

// The initial state of the Tasks container
export const initialState: ContainerState = {
  transactions: [],
  period: { startDate: '2023-07-04', endDate: '2024-07-31' },
  totalTransactionsCount: null,
};

const summarySlice = createSlice({
  name: 'summary',
  initialState,
  reducers: {
    getTransactions() {},
    setTransactions(state, action: PayloadAction<TransactionsResponse>) {
      let data = [] as Transaction[];
      for (let i = 0; i < action.payload.data.transactions.totalCount; ++i) {
        data.push(action.payload.data.transactions.edges[i].node);
      }
      state.transactions = data;
      state.totalTransactionsCount = action.payload.data.transactions.totalCount;
    },
  },
});

export const { actions: summaryActions, reducer, name: sliceKey } = summarySlice;
