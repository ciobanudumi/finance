import { AppState } from '../app/containers/App/types';
import { LayoutState } from '../app/containers/Theme/Layout/types';
import { LoginState } from '../app/containers/Security/Login/types';
import { SetPasswordState } from '../app/containers/Security/SetPassword/types';
import { UserSelectState } from '../app/components/UserSelect/types';
import { DashboardState } from '../app/containers/Dashboard/types';
import { SummaryState } from '../app/containers/Summary/types';

export interface RootState {
  login?: LoginState;
  setPassword?: SetPasswordState;
  userSelect?: UserSelectState;
  dashboard?: DashboardState;
  summary?: SummaryState;
  app?: AppState;
  layout?: LayoutState;
}
