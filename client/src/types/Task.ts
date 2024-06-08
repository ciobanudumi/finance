import { Company } from './Company';
import { User } from './User';
import { TaskSet } from './TaskSet';
import { ContactPerson } from './ContactPerson';
import { TaskPatchInstall } from './TaskPatchInstall';
import { TaskOnsiteInstallation } from './TaskOnsiteInstallation';
import { TaskPatchRemove } from './TaskPatchRemove';
import { TaskPatchMigrate } from './TaskPatchMigrate';
import { PaginationInfo } from './PaginationInfo';
import { PortalCode } from './PortalCode';

export interface Task {
  id: number | string;
  company: Company;
  contactPerson: ContactPerson | null;
  taskSet: TaskSet | null;
  region: number;
  preferredExecutor: User | null;
  onBehalfOf: string | null;
  wishDate: string | null;
  executionDate: string | null;
  finished: string | null;
  createdAt: string | null;
  migration: boolean;
  portType: string | null;
  taskType: string;
  status: string;
  holdCode: PortalCode | null;
  holdReason: string | null;
  holdExpectedResumeDate: string | null;
}

export interface TasksData {
  totalCount: number | null;
  data: Task[] | null;
}

export interface TasksDataResponse {
  data: {
    tasks: {
      collection: Task[] | null;
      paginationInfo: PaginationInfo;
    };
  };
}

export interface TaskDataResponse {
  data: {
    [key: string]: TaskPatchInstall | TaskPatchMigrate | TaskPatchRemove | TaskOnsiteInstallation | null;
  };
}
