import { PaginationInfo } from './PaginationInfo';

export interface TaskType {
  id: number;
  name: string;
}

export interface TaskTypesDataResponse {
  data: {
    taskTypes: {
      collection: TaskType[] | null;
      paginationInfo: PaginationInfo;
    };
  };
}

export interface TaskTypeSearch {
  name: string | null;
  itemsPerPage: number | null;
  taskTypesWithMatchingCriteria: boolean | null;
  taskTypesWithMatchingCriteriaForUser: number | null;
}

export interface TaskTypeOption {
  name: string;
  path: string;
}

export const TASK_TYPES: TaskTypeOption[] = [
  {
    name: 'task_patch_install',
    path: 'create-task-patch-install',
  },
  {
    name: 'task_patch_migrate',
    path: 'create-task-patch-migrate',
  },
  {
    name: 'task_patch_remove',
    path: 'create-task-patch-remove',
  },
  {
    name: 'task_onsite_installation',
    path: 'create-task-onsite-installation',
  },
];
