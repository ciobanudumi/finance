/* --- STATE --- */
export interface AppState {
  token: string | null;
  loading: boolean;
  focus: boolean;
  isFormSubmitting: boolean;
  sessionStartTime: string | null;
  user: User | null;
  notifications: Notification[] | null;
  refresh_token: string | null;
}

export interface User {
  id: string;
  username: string;
  name: string;
  roles: string[] | null;
}
export interface Notification {
  id: string;
  type: string;
  message: string;
  title: string | null;
  dismissCallback: Function | null;
}

export type ContainerState = AppState;
