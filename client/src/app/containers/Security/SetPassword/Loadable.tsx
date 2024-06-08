import { lazyLoad } from 'utils/loadable';

export const SetPassword = lazyLoad(
  () => import('./index'),
  module => module.default,
);
