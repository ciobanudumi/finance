import { PaginationInfo } from './PaginationInfo';

export interface User {
  id: number;
  name: string;
  username: string;
  email: string;
}

export interface UsersDataResponse {
  data: {
    users: {
      collection: User[] | null;
      paginationInfo: PaginationInfo;
    };
  };
}

export interface UserSearch {
  name: string | null;
  itemsPerPage: number | null;
  assigneeTaskSetMatchingCriteria: number | null;
}
