import { cloneDeep } from '@apollo/client/utilities';
import { generateRoute } from '../utils/routeHandling';
import { CNavItem } from '@coreui/react';
import { cilBalanceScale, cilSettings, cilSpeedometer } from '@coreui/icons';

const _nav = [
  {
    component: CNavItem,
    name: 'dashboard',
    to: '/dashboard',
    icon: cilSpeedometer,
  },
  {
    component: CNavItem,
    name: 'summary',
    to: '/summary',
    icon: cilBalanceScale,
  },
  {
    component: CNavItem,
    name: 'settings',
    to: '/settings',
    icon: cilSettings,
  },
];

export function allowedMenuItems(items): Array<any> {
  let allowedItems;
  // eslint-disable-next-line array-callback-return
  allowedItems = items.filter(menuItem => {
    if (isAllowed(menuItem)) {
      menuItem.to = generateRoute(menuItem.to);

      if (menuItem.children) {
        const allowedChildren = [{}];
        menuItem.children.forEach(child => {
          if (isAllowed(child)) {
            child.to = generateRoute(child.to);
            allowedChildren.push(child);
          }
        });

        menuItem.children = allowedChildren;
      }

      return menuItem;
    }
  });
  allowedItems = cloneDeep(allowedItems);
  allowedItems.forEach(item => {
    delete item.isGrantedFunction;
  });

  return allowedItems;
}

const isAllowed = menuItem =>
  !('isGrantedFunction' in menuItem) || ('isGrantedFunction' in menuItem && menuItem.isGrantedFunction());

export default _nav;
