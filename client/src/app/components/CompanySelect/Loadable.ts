import { lazyLoad } from 'utils/loadable';

export const CompanySelect = lazyLoad(
  () => import('./index'),
  module => module.default,
);
