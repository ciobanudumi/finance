/* --- STATE --- */
export interface LoginState {
  authenticationError: boolean | null;
  refreshError: boolean;
}
export interface InputFields {
  username: string;
  password: string;
}

export type ContainerState = LoginState;
