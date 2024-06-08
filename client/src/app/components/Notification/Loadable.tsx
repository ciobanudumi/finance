/**
 * Asynchronously loads the component for NotFoundPage
 */

import { lazyLoad } from 'utils/loadable';

export const Notification = lazyLoad(
  () => import('./index'),
  module => module.default,
);
