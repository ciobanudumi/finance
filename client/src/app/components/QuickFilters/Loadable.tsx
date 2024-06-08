import { lazyLoad } from 'utils/loadable';

export const QuickFilters = lazyLoad(
  () => import('./index'),
  module => module.default,
);
