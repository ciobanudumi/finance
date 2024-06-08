export interface SetPasswordState {
  isFormSubmitting: boolean;
  token: string | null;
  error: boolean | null;
  errorMessage: string | null;
}

export type ContainerState = SetPasswordState;
