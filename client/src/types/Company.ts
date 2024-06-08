import { PaginationInfo } from './PaginationInfo';

export interface Company {
  id: number | string;
  name: string;
  administrativeDisabled: boolean;
  fiberCrewId: number | undefined;
}

export interface CompanySearch {
  name: string | null;
  itemsPerPage: number | null;
  administrativeDisabled: boolean;
  companiesWithMatchingCriteria: boolean | null;
  companiesWithMatchingCriteriaForUser: number | null;
  companiesWithMatchingCriteriaOfTaskType: string | null;
}

export interface CompaniesDataResponse {
  data: {
    companies: {
      collection: Company[] | null;
      paginationInfo: PaginationInfo;
    };
  };
}
