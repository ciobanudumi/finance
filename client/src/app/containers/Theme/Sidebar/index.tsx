import React, { useEffect, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { CNavTitle, CSidebar, CSidebarBrand, CSidebarNav, CSidebarToggler } from '@coreui/react';
// sidebar nav config
import navigation, { allowedMenuItems } from '../../../_nav';
import { selectSidebarShow, selectSidebarUnfoldable } from '../Layout/selectors';
import i18next from 'i18next';
import CIcon from '@coreui/icons-react';
import { layoutActions } from '../Layout/slice';
import { NavLink } from 'react-router-dom';
import { CNavItem } from '@coreui/react-pro';

export const Sidebar = () => {
  const dispatch = useDispatch();
  const [grantedMenuItems, setGrantedMenuItems] = useState(Array<any>());
  const [navItems, setNavItems] = useState(Array<React.JSX.Element>());
  const showSidebar = useSelector(selectSidebarShow);
  const unfoldableSidebar = useSelector(selectSidebarUnfoldable);

  useEffect(() => {
    setGrantedMenuItems(allowedMenuItems(navigation));
    // eslint-disable-next-line
  }, [i18next.language]);

  useEffect(() => {
    if (grantedMenuItems.length > 0) {
      setNavItems(
        grantedMenuItems.map((navItem, index) => {
          return (
            <>
              {navItem.to ? (
                <CNavItem component={NavLink} to={navItem.to} key={index}>
                  <CIcon customClassName="nav-icon" icon={navItem.icon} />
                  {navItem.name.charAt(0).toUpperCase() + navItem.name.slice(1)}
                </CNavItem>
              ) : (
                <CNavTitle key={index}>
                  <CIcon customClassName="nav-icon" icon={navItem.icon} />
                  {navItem.name}
                </CNavTitle>
              )}
            </>
          );
        }),
      );
    }
  }, [grantedMenuItems]);

  return (
    <CSidebar position="fixed" visible={showSidebar} unfoldable={unfoldableSidebar}>
      <CSidebarNav>
        <CSidebarBrand>
          <h4>Finance</h4>
        </CSidebarBrand>
        {navItems}
      </CSidebarNav>
      <CSidebarToggler
        className="d-none d-lg-flex"
        onClick={() => dispatch(layoutActions.setSidebarUnfoldable(!unfoldableSidebar))}
      />
    </CSidebar>
  );
};
