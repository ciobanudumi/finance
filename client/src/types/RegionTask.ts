import { PaginationInfo } from './PaginationInfo';

export interface RegionTask {
  region: number;
}

export interface RegionsDataResponse {
  data: {
    tasks: {
      collection: RegionTask[] | null;
      paginationInfo: PaginationInfo;
    };
  };
}
