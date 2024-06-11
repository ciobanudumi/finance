import React, { memo } from 'react';

import { CFooter } from '@coreui/react';
import { useTranslation } from 'react-i18next';

export const Footer = memo(() => {
  const { i18n, t } = useTranslation();
  return (
    <CFooter>
      <div className="ml-1"></div>
      <div className="mfs-auto">
        <span className="ml-auto">&copy; {new Date().getFullYear()} Finance</span>
      </div>
    </CFooter>
  );
});
