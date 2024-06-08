import { Company } from '../../../types/Company';

export interface CompanySelectState {
  companies: Company[] | null;
}

export type ContainerState = CompanySelectState;
