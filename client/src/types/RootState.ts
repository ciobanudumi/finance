import { AppState } from '../app/containers/App/types';
import { LayoutState } from '../app/containers/Theme/Layout/types';
import { LoginState } from '../app/containers/Security/Login/types';
import { SetPasswordState } from '../app/containers/Security/SetPassword/types';
import { CompanySelectState } from '../app/components/CompanySelect/types';
import { UserSelectState } from '../app/components/UserSelect/types';

export interface RootState {
  login?: LoginState;
  setPassword?: SetPasswordState;
  companySelect?: CompanySelectState;
  userSelect?: UserSelectState;
  app?: AppState;
  layout?: LayoutState;
}
