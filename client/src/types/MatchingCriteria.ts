import { PaginationInfo } from './PaginationInfo';

export interface MatchingCriterion {
  id: number;
  user: { name: string };
  company: { name: string };
  maxRegion: number;
  minRegion: number;
  taskType: { name: string };
}

export interface MatchingCriteriaData {
  totalCount: number | null;
  data: MatchingCriterion[] | null;
}

export interface MatchingCriteriaDataResponse {
  data: {
    matchingCriterias: {
      collection: MatchingCriterion[] | null;
      paginationInfo: PaginationInfo;
    };
  };
}

export interface MatchingCriteriaSearch {
  taskTypeNamesList: string[] | null;
  companyIdsList: number[] | null;
  userIdsList: number[] | null;
}
