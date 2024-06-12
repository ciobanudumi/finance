import React, { memo } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { CContainer, CHeader, CHeaderDivider, CHeaderToggler } from '@coreui/react';
import CIcon from '@coreui/icons-react';
import { cilLockLocked, cilMenu, cilUser } from '@coreui/icons';

import { selectSidebarShow } from '../Layout/selectors';
import { layoutActions } from '../Layout/slice';
import { privateRoutes } from '../../../routes';
import { useLocation, useNavigate } from 'react-router-dom';
import { AppRoutes } from '../../../../types/AppRoutes';
import {
  CBreadcrumb,
  CBreadcrumbItem,
  CDropdown,
  CDropdownItem,
  CDropdownMenu,
  CDropdownToggle,
  CHeaderNav,
  CSpinner,
} from '@coreui/react-pro';
import { Breadcrumb } from './types';
import { useTranslation } from 'react-i18next';
import { selectLoading, selectUser } from '../../App/selectors';
import { appActions } from '../../App/slice';

export const Header = memo(() => {
  const dispatch = useDispatch();
  const sidebarShow = useSelector(selectSidebarShow);
  const { t } = useTranslation();
  const loading = useSelector(selectLoading);
  const navigate = useNavigate();
  const user = useSelector(selectUser);
  const currentLocation = useLocation().pathname;

  const onLogout = () => {
    dispatch(appActions.clearUserData());
    navigate('/login');
  };

  const getRouteName = (pathname, routes) => {
    const currentRoute = routes.find(route => route.path === pathname);
    return currentRoute ? currentRoute.name : false;
  };

  const getBreadcrumbs = (location, appRoutes: AppRoutes[]) => {
    const breadcrumbs: Breadcrumb[] = [];
    location.split('/').reduce((prev, curr) => {
      const currentPathname = `${prev}/${curr}`;
      const routeName = getRouteName(currentPathname, appRoutes);
      routeName &&
        breadcrumbs.push({
          pathname: currentPathname,
          name: routeName,
        });
      return currentPathname;
    });
    return breadcrumbs;
  };

  const breadcrumbs = getBreadcrumbs(currentLocation, privateRoutes());

  return (
    <CHeader position="sticky" className="mb-4">
      <CContainer fluid>
        <CHeaderToggler className="ps-1" onClick={() => dispatch(layoutActions.setSidebarShow(!sidebarShow))}>
          <CIcon icon={cilMenu} size="lg" />
        </CHeaderToggler>
        <CHeaderNav className="ml-auto">
          {loading ? <CSpinner size="sm" className="mr-3" /> : ''}
          <CDropdown className="m-2" variant="nav-item">
            <CDropdownToggle caret={false} className="text-medium-emphasis">
              <CIcon icon={cilUser} size="lg" className="me-1" />
              {user?.name}
            </CDropdownToggle>
            <CDropdownMenu className="m-0">
              <CDropdownItem onClick={() => onLogout()}>
                <CIcon className="mr-2" icon={cilLockLocked} />
                Logout
              </CDropdownItem>
            </CDropdownMenu>
          </CDropdown>
        </CHeaderNav>
      </CContainer>
      <CHeaderDivider />
      <CBreadcrumb className="m-0 ms-2 my-2">
        {breadcrumbs.map((breadcrumb, index) => {
          return (
            <CBreadcrumbItem href={breadcrumb.pathname} key={index} className="text-decoration-none">
              {breadcrumb.name.charAt(0).toUpperCase() + breadcrumb.name.slice(1)}
            </CBreadcrumbItem>
          );
        })}
      </CBreadcrumb>
    </CHeader>
  );
});
