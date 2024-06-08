import { User } from '../../../types/User';

export interface UserSelectState {
  users: User[] | null;
}

export type ContainerState = UserSelectState;
