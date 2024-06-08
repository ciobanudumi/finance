import React, { memo } from 'react';

import { useTranslation } from 'react-i18next';

export function RenderBoolean({ boolValue }) {
  const { t } = useTranslation();

  // eslint-disable-next-line no-nested-ternary
  return <>{boolValue === true ? 'Yes' : boolValue === false ? 'No': null}</>;
}

export default memo(RenderBoolean);
