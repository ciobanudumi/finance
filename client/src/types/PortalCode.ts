import { TaskType } from './TaskType';
import { PaginationInfo } from './PaginationInfo';

export interface PortalCode {
  id: number | string;
  type: string | null;
  code: string | null;
  description: string | null;
  $taskTypes: TaskType[] | null;
}

export interface PortalCodeDataResponse {
  data: {
    portalCodes: {
      collection: PortalCode[] | null;
      paginationInfo: PaginationInfo;
    };
  };
}
