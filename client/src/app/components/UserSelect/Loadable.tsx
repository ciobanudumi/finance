import { lazyLoad } from 'utils/loadable';

export const UserSelect = lazyLoad(
  () => import('./index'),
  module => module.default,
);
