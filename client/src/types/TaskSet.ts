import { PaginationInfo } from './PaginationInfo';

export interface TaskSet {
  id: number;
  status: string;
  assignee: {
    id: number | null;
    name: string | null;
  } | null;
  planned: string | null;
  tasks: {
    collection: TaskSet[];
  } | null;
}

export interface TaskSetsDataResponse {
  data: {
    taskSets: {
      collection: TaskSet[] | null;
      paginationInfo: PaginationInfo;
    };
  };
}

export interface TaskSetsData {
  totalCount: number | null;
  data: TaskSet[] | null;
}

export interface TaskSetItemDataResponse {
  data: {
    taskSet: TaskSet | null;
  };
}

export interface TaskSetSearch {
  id: string | null;
  itemsPerPage: number | null;
  taskSetsWithTaskMatchingCriteria: number | null;
}
