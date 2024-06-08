import { store } from '../store/store';
import { selectUser } from '../app/containers/App/selectors';
import { isString } from 'lodash';

export function checkUserRoles(roles: string[] | string): boolean {
  const user = selectUser(store.getState());
  let allowed = true;
  if (isString(roles)) {
    return !!user?.roles?.includes(roles);
  }
  roles.forEach(role => {
    if (!user?.roles?.includes(role)) {
      allowed = false;
    }
  });

  return allowed;
}
