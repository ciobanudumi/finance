import { PayloadAction } from '@reduxjs/toolkit';
import { createSlice } from 'utils/@reduxjs/toolkit';
import { ContainerState } from './types';
import { CompaniesDataResponse, CompanySearch } from '../../../types/Company';

// The initial state of the CompanySelect container
export const initialState: ContainerState = {
  companies: null,
};

const companySelectSlice = createSlice({
  name: 'companySelect',
  initialState,
  reducers: {
    getCompanies(state, action: PayloadAction<CompanySearch>) {},
    setCompaniesData(state, action: PayloadAction<CompaniesDataResponse>) {
      state.companies = action.payload.data.companies.collection;
    },
  },
});

export const { actions: companySelectActions, reducer, name: sliceKey } = companySelectSlice;
