import React, { memo } from 'react';

import { CFooter } from '@coreui/react';
import { useTranslation } from 'react-i18next';

export const Footer = memo(() => {
  const { i18n, t } = useTranslation();
  return (
    <CFooter>
      <div className="ml-1">
        <select onChange={event => i18n.changeLanguage(event.target.value)} defaultValue={i18n.language}>
          <option value="en">EN</option>
          <option value="nl">NL</option>
        </select>
      </div>
      <div className="mfs-auto">
        <span className="ml-auto">&copy; {new Date().getFullYear()} Finance</span>
      </div>
    </CFooter>
  );
});
